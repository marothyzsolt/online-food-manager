<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileUpdateRequest extends FormRequest
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
            'email' => 'required|email',
            'name' => 'required',
            'phone' => 'required',
        ] + $dayRules;
    }
}
