<?php

namespace App\Services;

use App\Models\Transaction;
use App\Repositories\Transaction\TransactionsRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\File\Exception\AccessDeniedException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\Translation\Exception\NotFoundResourceException;


class TransactionService
{
    public function __construct(private TransactionsRepositoryInterface $transactionRepository)
    {

    }

    public function createTransaction($data)
    {
        return $this->transactionRepository->create($data);
    }

    public function initialTransactionStatus(Transaction $transaction)
    {
        $currentTime = now();
        $dueOnDate = \Carbon\Carbon::parse($transaction->due_on);
        if ($currentTime > $dueOnDate) {
            $transaction->update(['status' => 'Overdue']);
        } else if ($currentTime < $dueOnDate) {
            $transaction->update(['status' => 'Outstanding']);
        }
    }

    public function getUserTransactions()
    {
        $user = auth()->guard('api')->user();
        if ($user->role == 'admin') {
            // Admin can view all transactions
            return Transaction::with('payments')->get();
        } else {
            // User can view only their transactions
            return $user->transactions()->with('payments')->get();

        }
    }

    public function getTransactionById(int $transactionId)
    {
        // Fetch the transaction by its ID
        $transaction = $this->transactionRepository->getById($transactionId);
        // Check if the transaction exists
        if (!$transaction) {
            throw  new NotFoundResourceException('No Transaction found.', 404);
        }

        // Check authorization based on user role
        $user = auth()->guard('api')->user();
        if ($user->role === 'admin' || $user->id === $transaction->payer) {
            return $transaction;
        }
        throw  new \Exception('Access Denied', 403);

    }

    public function generateMonthlyReport(string $startDate, string $endDate): Collection
    {
        $reports = Transaction::select(
            DB::raw('MONTH(created_at) as month'),
            DB::raw('YEAR(created_at) as year'),
            DB::raw('SUM(amount) as paid'),
            DB::raw('SUM(CASE WHEN status = "Outstanding" THEN amount ELSE 0 END) as outstanding'),
            DB::raw('SUM(CASE WHEN status = "Overdue" THEN amount ELSE 0 END) as overdue')
        )
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy(DB::raw('MONTH(created_at)'), DB::raw('YEAR(created_at)'))
            ->get()
            ->map(function ($report) {
                return [
                    'month' => $report->month,
                    'year' => $report->year,
                    'paid' => $report->paid,
                    'outstanding' => $report->outstanding,
                    'overdue' => $report->overdue,
                ];
            });
        return $reports;
    }
}
