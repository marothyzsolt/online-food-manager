<?php

namespace App\Http\Requests;

use App\Models\ItemPrice;
use Illuminate\Foundation\Http\FormRequest;

class UpdateRestaurantItemRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'description' => 'required',
            'price' => 'required|numeric|min:0',
            'make_time' => 'required|numeric|min:0',
            'media.*' => 'mimes:jpeg,jpg,png,gif|image',
            'discount_type' => 'required',
            'discount' => 'numeric|min:1|' . ($this->request->get('discount_type') === ItemPrice::DISCOUNT_TYPE_PERCENTAGE ? 'max:100' : 'max:' . $this->request->get('price')),
        ];
    }
}
