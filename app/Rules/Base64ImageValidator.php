<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class Base64ImageValidator implements Rule
{
    public function passes($attribute, $value): bool
    {
        $explode = explode(',', $value);
        $allow = ['png', 'jpg', 'svg'];
        $format = str_replace(
            [
                'data:image/',
                ';',
                'base64',
            ],
            [
                '', '', '',
            ],
            $explode[0]
        );

        return
            in_array($format, $allow) ?
                preg_match('%^[a-zA-Z0-9/+]*={0,2}$%', $explode[1]) :
                false;
    }

    public function message(): string
    {
        return 'Invalid image format.';
    }
}
