<?php

namespace App\Http\Requests;


class UpdateLocationRequest extends LocationRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        
            $rules = Parent::rule();

            $rules['user_id']='required|exists:users,id';


            return $rules;
    }
}
