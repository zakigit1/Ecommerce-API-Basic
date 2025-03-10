<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest extends FormRequest
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
        return [
            'total_price'=>'required|min:0|numeric',
            'date_of_delivery'=>'required|string',
            'order_items'=>'required|array|min:1',
            'order_items.*.product_id'=>'required|numeric|exists:products,id',
            'order_items.*.quantity'=>'required|numeric|min:1',
            'order_items.*.price'=>'required|numeric|min:0',
        ];
    }
}
