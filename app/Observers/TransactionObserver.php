<?php

namespace App\Observers;


use App\Models\Transaction;

class TransactionObserver
{
    /**
     * @param Transaction $transaction
     * @return void
     */
    //
    public function retrieved(Transaction $transaction)
    {
        // Check if the due date has passed and the status is not "Paid"
        if ($transaction->due_on < \Carbon\Carbon::now() && $transaction->status !== 'Paid') {
            $transaction->status = 'Overdue';
            $transaction->save();
        }
    }

}
