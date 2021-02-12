<?php

namespace App\Http\Requests;

use App\Models\Product;
use Illuminate\Foundation\Http\FormRequest;

class CheckoutRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
    */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
    */
    public function prepareForValidation(): void
    {
        $product = Product::find($this->product_id);

        $this->merge([
            'product_id' => $this->product_id,
            'qty' => $this->qty,
            'product' => $product,
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
    */
    public function rules(): array
    {
        $rules = [
            'product_id' => 'required|integer|min:1|exists:products,id',
            'qty' => 'required|integer|min:1',
        ];

        if ($this->qty > 0 && $this->product instanceof Product) {
            $rules['qty'] .= '|max:' . $this->product->stock;

            if ($this->product->qty === 0) {
                $rules['qty'] = \str_replace('|min:1', '', $rules['qty']);
            }
        }

        return $rules;
    }

    /**
     * Get the validation messages that apply to the request.
     *
     *  @return array
    */
    public function messages(): array
    {
        return [
            'product_id.required' => 'Please choise a product',
            'product_id.exists' => 'Product not available',
            'qty.required' => 'Please fill the stock',
            'qty.min' => 'Please add stock min 1',
            'qty.max' => 'Sory, the stock is not enough',
        ];
    }
}