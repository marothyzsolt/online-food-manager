<?php

namespace App\Http\Requests\Restaurant;

use Illuminate\Foundation\Http\FormRequest;

class StoreRestaurantRequest extends FormRequest
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
        $dayRules = [];
        foreach (request()->get('days') as $day => $item) {
            if (isset($item['to']) && $item['to'] > 0) {
                $dayRules['days.' . $day . '.from'] = 'lt:' . $item['to'] . ',min:0|max:24';
            }
            if (isset($item['from']) && $item['from'] > 0) {
                $dayRules['days.' . $day . '.to'] = 'gt:' . $item['from'] . ',min:0|max:24';
            }
        }

        return [
                'name' => 'required|string|max:50|min:2|unique:restaurants',
                'description' => 'required|string|max:1000',
                'style' => 'required|string|max:20',
                'address' => 'required|string|max:30',
                'phone' => 'required|string|max:12|min:12',
                'email' => 'required|email',
                'days' => 'array|size:7',
                'media' => 'mimes:jpeg,jpg,png,gif|image'
            ] + $dayRules;
    }
}
