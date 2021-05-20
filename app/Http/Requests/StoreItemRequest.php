<?php

namespace App\Http\Requests;

use App\Models\ItemPrice;
use Illuminate\Foundation\Http\FormRequest;

class StoreItemRequest extends FormRequest
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
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|min:3',
            'description' => 'required|string|min:3|max:1000',
            'price' => 'required|numeric',
            'discount_type' => 'nullable|in_array:' . implode(',', ItemPrice::DISCOUNT_TYPE_LIST),
            'discount_value' => 'numeric',
        ];
    }
}
