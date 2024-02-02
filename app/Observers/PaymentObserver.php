<?php

namespace App\Observers;

use App\Models\Payment;
use App\Services\PaymentService;

class PaymentObserver
{
    /**
     * @param PaymentService $paymentService
     */
    public function __construct(private PaymentService $paymentService)
    {

    }

    //

    /**
     * @param Payment $payment
     * @return void
     */
    public function created(Payment $payment)
    {
        // Perform actions when a new payment is created
        $this->paymentService->updateTransactionStatus($payment->transaction, $payment);
    }

    /**
     * @param Payment $payment
     * @return void
     */
    public function retrieved(Payment $payment)
    {
        // Update the status while retrieved
        $this->paymentService->updateTransactionStatus($payment->transaction, $payment);
    }

}
