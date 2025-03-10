<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends StoreProductRequest
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
        // this first line and the last of return is important :
        $rules=Parent::rules();
        // what you want to modify of fields : 
            
            $rules['image']='nullable|mimes:jpg,jpeg,png';

            unset($rules['category_id']);
            unset($rules['brand_id']);
            

        return $rules;
    }
}
