<?php

namespace App\Repositories\Transaction;

interface TransactionsRepositoryInterface
{
    public function getById(int $id);

    public function getAll();

    public function create(array $data);
}
