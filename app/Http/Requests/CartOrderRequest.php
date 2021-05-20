<?php

namespace App\Http\Requests;

use App\Models\Order;
use Illuminate\Foundation\Http\FormRequest;

class CartOrderRequest extends FormRequest
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
        return match ($this->request->get('type', -1)) {
            Order::TYPE_PERSONAL => [
                'name' => 'required',
                'phone' => 'required',
                'email' => 'required|email',
                'comment' => 'string',
            ],
            Order::TYPE_DELIVERY => [
                'name' => 'required',
                'zip' => 'required|numeric',
                'city' => 'required',
                'address' => 'required',
                'phone' => 'required',
                'email' => 'required|email',
                'comment' => 'string',
            ],
            default => ['type' => 'required|digits_between:0,1'],
        };
    }
}
