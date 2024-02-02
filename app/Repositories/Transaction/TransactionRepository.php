<?php

namespace App\Repositories\Transaction;

use App\Models\Transaction;
use Illuminate\Database\Eloquent\Collection;

class TransactionRepository implements TransactionsRepositoryInterface
{
    public function __construct(private Transaction $transaction)
    {
    }

    /**
     * @return void
     */
    public function getAll()
    {

    }

    public function create(array $data): Transaction
    {
        return $this->transaction->create($data);
    }

    public function getStatus(int $id): string
    {
        return $this->getById($id)->status;
    }

    public function getById($id)
    {
        return $this->transaction->find($id);
    }

}
