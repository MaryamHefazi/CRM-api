<?php

namespace App\Http\Requests;

use App\Models\Product;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Spatie\Permission\Contracts\Role;

class StoreOpportunityRequest extends FormRequest
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
            'products' => 'required',
            'products.*' => Rule::forEach(function(string|null $value , string $attribute){
                return[
                    Rule::exists(Product::class,'id')->whereNull('deleted_at')
                ];
            }),
            'number' => 'required|numeric',
            'color' => 'required',
            'price' => 'required|numeric',
            'total_price' => 'required|numeric',
            'status' => 'required'
        ];
    }
}
