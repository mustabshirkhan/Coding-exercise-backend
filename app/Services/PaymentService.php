<?php

namespace App\Services;

use App\Models\Payment;
use App\Models\Transaction;
use App\Repositories\Payment\PaymentRepositoryInterface;
use App\Repositories\Transaction\TransactionsRepositoryInterface;
use App\Exceptions\AlreadyPaidException;
use Symfony\Component\Translation\Exception\NotFoundResourceException;

class PaymentService
{
    public function __construct(private PaymentRepositoryInterface $paymentRepository, private TransactionsRepositoryInterface $transactionsRepository)
    {
    }

    public function recordPayment(array $data)
    {
        $this->validatePaymentAmount($data['transaction_id'], $data['amount']);
        if ($this->checkTransactionStatus($data['transaction_id']) == 'Paid') {
            throw new AlreadyPaidException('Unable to make payment of fully paid transaction.', 400);
        }
        $payment = $this->paymentRepository->create($data);
        $this->updateTransactionStatus($payment->transaction, $payment);
        return $payment;
    }

    public function validatePaymentAmount(int $tranId, int $paymentAmt): float|string
    {
        $transaction = Transaction::find($tranId);
        if (!$transaction) {
            throw new NotFoundResourceException('Transaction id not found.', 404);
        } else if ((float)$transaction->amount < $paymentAmt) {
            throw new \Exception('Invalid payment amount, It should always less than equal to transaction amount.', 400);
        }
        return (float)$transaction->amount;
    }

    public function checkTransactionStatus(int $transId)
    {
        return $this->transactionsRepository->getStatus($transId);
    }

    public function updateTransactionStatus(Transaction $transaction, Payment $payment)
    {
        // Logic to update the transaction status based on payments
        // Example: Update to 'Paid' if the total amount is paid
        $paidOn = \Carbon\Carbon::parse($payment->paid_on);
        $dueOn = \Carbon\Carbon::parse($transaction->due_on);

        $totalPaidAmount = $transaction->payments()->sum('amount');
        $totalTransactionAmount = $transaction->amount;

        if ($totalPaidAmount >= $totalTransactionAmount) {
            $transaction->status = 'Paid';
        } elseif ($dueOn > $paidOn) {
            $transaction->status = 'Outstanding';
        } elseif ($dueOn < $paidOn) {
            $transaction->status = 'Overdue';
        }
        $transaction->save();
    }
}
