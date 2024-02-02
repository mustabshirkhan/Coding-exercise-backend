<?php

namespace App\Http\Requests;

use App\Models\Payment;
use App\Models\Transaction;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\Translation\Exception\NotFoundResourceException;

class PaymentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {

        $transactionAmount = $this->getTransactionAmount($this->input('transaction_id'));

        return [
            'transaction_id' => 'required|exists:transactions,id',
            'amount' => 'required|numeric',
            'paid_on' => 'required|date',
            'details' => 'nullable|string',
        ];

    }

    public function getTransactionAmount(int $tranId): float|string
    {
        $transaction = Transaction::find($tranId);
        if (!$transaction) {
            throw new NotFoundResourceException('Transaction id not found.', 404);
        }
        return (float)$transaction->amount;
    }
}
