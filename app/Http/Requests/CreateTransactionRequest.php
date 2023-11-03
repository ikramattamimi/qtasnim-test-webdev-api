<?php

namespace App\Http\Requests;

use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Foundation\Http\FormRequest;

class CreateTransactionRequest extends FormRequest
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
        $id = $this->route('transaction');
        $productStock = Product::find($this->input('product_id'))->stock ?? 0;
        $transactionQty = Transaction::find($id)->qty ?? 0;

        return [
            'product_id' => 'required|exists:products,id',
            'qty' => 'required|numeric|max:' . $productStock + $transactionQty,
            'transaction_date' => 'required|date'
        ];
    }
}
