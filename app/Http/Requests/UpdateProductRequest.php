<?php

namespace App\Http\Requests;

use App\Models\Category;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProductRequest extends FormRequest
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
            'productName'=>'sometimes',
            'categories'=>'sometimes|array',
            'categories.*' => Rule::forEach(function(string|null $value,string $art){
                return[
                    Rule::exists(Category::class,'id')->whereNull('deleted_at')
                ];
            }),
            'number'=>'sometimes|numeric',
            'price'=>'sometimes|numeric',
            'color'=>'sometimes'
        ];
    }
}
