<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\PaymentService;
use App\Http\Requests\PaymentRequest;

class PaymentController extends Controller
{
    //
    public function __construct(private readonly PaymentService $paymentService)
    {
    }

    public function recordPayment(PaymentRequest $request)
    {
        try {
            $payment = $this->paymentService->recordPayment($request->all());
            return $this::success($payment, 'Payment recorded successfully', 200);
        } catch (\Exception $e) {
            return $this::error($e->getMessage(), $e->getCode());
        }
    }
}
