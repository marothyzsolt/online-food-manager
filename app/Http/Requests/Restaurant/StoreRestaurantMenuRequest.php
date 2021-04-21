<?php

namespace App\Http\Requests\Restaurant;

use App\Rules\Base64ImageValidator;
use Illuminate\Foundation\Http\FormRequest;

class StoreRestaurantMenuRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|min:3',
            'description' => 'string|max:1000',
            'image' => [new Base64ImageValidator()],
        ];
    }
}
