<?php

namespace App\Repositories\Payment;

interface PaymentRepositoryInterface
{
    public function getById(int $id);

    public function getAll();

    public function create(array $data);
}
