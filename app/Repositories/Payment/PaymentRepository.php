<?php

namespace App\Repositories\Payment;

use App\Models\Payment;

class PaymentRepository implements PaymentRepositoryInterface
{
    public function __construct(private Payment $payment)
    {
    }

    public function getById($id)
    {
        return $this->payment->find($id);
    }

    public function getAll()
    {

    }

    public function create(array $data)
    {
        return $this->payment->create($data);
    }

}
