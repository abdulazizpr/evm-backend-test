<?php

namespace App\Http\Requests;

use App\Models\Product;
use Illuminate\Foundation\Http\FormRequest;

class PaymentRequest extends FormRequest
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
        $products = [];
        foreach ($this->products as $key => $product) {
            $products['products'][$key] = [
                'id' => $product['id'],
                'qty' => $product['qty'],
                'product' => Product::find($product['id']),
            ];
        }

        $this->merge($products);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
    */
    public function rules(): array
    {
        $rules = [
            "products" => "required|array|min:1",
        ];

        foreach ($this->products as $key => $product) {
            $rules["products.$key.id"] = "required|integer|min:1|exists:products,id";
            $rules["products.$key.qty"] = "required|integer|min:1";

            if ($product['qty'] > 0 && $product['product'] instanceof Product) {
                $rules["products.$key.qty"] .= '|max:' . $product['product']->stock;

                if ($product['product']->stock === 0) {
                    $rules["products.$key.qty"] = str_replace('|min:1', '', $rules["products.$key.qty"]);
                }
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
        $messages = [
            'products.required' => 'Please add product min 1',
            'products.array' => 'Products must be an array',
            'products.min' => 'Please add product min 1',
        ];

        foreach ($this->products as $key => $product) {
            $messages["products.$key.id.required"] = 'Please choise a product';
            $messages["products.$key.id.exists"] = 'Product not available';
            $messages["products.$key.qty.min"] = 'Please add stock min 1';
            $messages["products.$key.qty.max"] = 'Sory, the stock is not enough';
        }

        return $messages;
    }
}
