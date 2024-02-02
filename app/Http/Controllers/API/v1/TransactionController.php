<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\MonthlyReportCollection;
use App\Http\Resources\MonthlyReportResource;
use App\Http\Resources\TransactionResource;
use App\Services\TransactionService;
use App\Http\Requests\TransactionRequest;
use Illuminate\Http\Request;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    //
    /**
     * @param TransactionService $transactionService
     */
    public function __construct(private TransactionService $transactionService)
    {
    }

    /**
     * @param TransactionRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(TransactionRequest $request)
    {
        $transaction = $this->transactionService->createTransaction($request->all());
        // Update transaction status based on the specified criteria
        $this->transactionService->initialTransactionStatus($transaction);
        return $this::success(new TransactionResource($transaction), 'Transaction created successfully', 201);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getUserTransactions()
    {
        try {
            $transactions = $this->transactionService->getUserTransactions();
            return $this::success($transactions, '');

        } catch (\Exception $e) {
            return $this::error($e->getMessage(), $e->getCode());
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function generateMonthlyReport(Request $request)
    {
        // Validate the input date range
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        // Get the input date range
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        // Generate the monthly report
        try {
            $reports = $this->transactionService->generateMonthlyReport($startDate, $endDate);
            return $this::success($reports, 'Successfully generated', 200);
        } catch (\Exception $e) {
            return $this::error($e->getMessage(), $e->getCode());
        }


    }

    /**
     * @param int $transactionId
     * @return \Illuminate\Http\JsonResponse
     */
    public function viewTransaction(int $transactionId)
    {
        try {
            $transaction = $this->transactionService->getTransactionById($transactionId);
            return $this::success(new TransactionResource($transaction), 'Resource successfully retrieved');

        } catch (\Exception $e) {
            return $this::error($e->getMessage(), $e->getCode());
        }

    }
}
