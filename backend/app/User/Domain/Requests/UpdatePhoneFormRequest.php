<?php

namespace App\User\Domain\Requests;

use App\Infrastructure\Http\Requests\API\CustomApiRequest;

/**
 * Class VerifyAccountFormRequest
 */
class UpdatePhoneFormRequest extends CustomApiRequest
{
    public function rules()
    {
        return [
            'country_code' => ['required', 'exists:countries,phone_code'],
            'phone' => ['required', 'digits_between:7,17'],
            'code' => ['required', 'numeric'],
        ];
    }
}
