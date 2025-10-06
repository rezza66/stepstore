<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCustomerDataRequest extends FormRequest
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
            'name'      => ['sometimes', 'required', 'string', 'max:255'],
            'email'     => ['sometimes', 'required', 'email', 'max:255'],
            'quantity'  => ['sometimes', 'required', 'integer', 'min:1'],
            'phone'     => ['sometimes', 'required', 'string', 'max:20'],
            'address'   => ['sometimes', 'required', 'string'],
            'city'      => ['sometimes', 'required', 'string', 'max:255'],
            'post_code' => ['sometimes', 'required', 'string', 'max:10'],
        ];
    }
}
