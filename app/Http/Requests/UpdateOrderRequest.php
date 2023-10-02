<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateOrderRequest extends FormRequest
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
            'user_id' => 'sometimes',
            'products' => 'sometimes',
            'products.*' => Rule::forEach(function(string|null $value,string $art){
                return[
                    Rule::exists(Product::class,'id')->whereNull('deleted_at')
                ];
            }),
            'description' => 'sometimes',
        ];
    }
}
