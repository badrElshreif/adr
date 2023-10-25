<?php

namespace App\User\Domain\Requests;

use App\Infrastructure\Http\Requests\API\CustomApiRequest;
use Illuminate\Contracts\Validation\Validator;

/**
 * Class VerifyAccountFormRequest
 */
class VerifyAccountFormRequest extends CustomApiRequest
{
    public function rules()
    {
//        if($this->send_type=='sms'){
//            $rules=[
//                'send_type' => ['required', 'in:sms,email'],
//                'phone' => ['required_if:send_type,sms', 'digits_between:7,17'],
//                'country_code' => ['required_if:send_type,sms', 'exists:countries,code'],
//                "code" => ['required', 'numeric'],
//                "device_token" => "sometimes|nullable|string|max:1000|min:1",
//                "device_id" => "sometimes|nullable|string|max:255|min:1",
//            ];
//        }else{
//            $rules=[
//                'send_type' => ['required', 'in:sms,email'],
//                'email' => ['required_if:send_type,email', 'email','max:75'],
//                "code" => ['required', 'numeric'],
//                "device_token" => "sometimes|nullable|string|max:1000|min:1",
//                "device_id" => "sometimes|nullable|string|max:255|min:1",
//            ];
//        }
//        return $rules;
        return [
            'type' => ['required', 'in:client,delivery'],
            'phone' => ['required', 'digits_between:7,17'],
            'country_code' => ['required', 'exists:countries,phone_code'],
            'code' => ['required', 'numeric'],
            'device_token' => 'sometimes|nullable|string|max:1000|min:1',
            'device_id' => 'sometimes|nullable|string|max:255|min:1',
        ];
    }

    // public function failedValidation(Validator $validator)
    // {
    //     throw new HttpResponseException(response()->json(['errors' => $validator->errors()], 422));
    // }
}
