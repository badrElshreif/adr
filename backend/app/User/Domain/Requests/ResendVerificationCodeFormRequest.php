<?php

namespace App\User\Domain\Requests;

use App\Infrastructure\Http\Requests\API\CustomApiRequest;

class ResendVerificationCodeFormRequest extends CustomApiRequest
{
    public function rules()
    {
//        if($this->send_type=='sms'){
            $rules = [
                //                'send_type' => ['required', 'in:sms,email'],
                'phone' => ['required', 'digits_between:7,17'],
                'country_code' => ['required', 'exists:countries,phone_code'],
                'type' => ['required', 'in:client,delivery'],
            ];
//        }else{
//            $rules=[
//                'send_type' => ['required', 'in:sms,email'],
//                'email' => ['required_if:send_type,email', 'email','max:75'],
//            ];
//        }
        return $rules;
//        return [
//            'send_type' => ['required', 'in:sms,email'],
//            'email' => ['required_if:send_type,email', 'email','max:75'],
//            'phone' => ['required_if:send_type,sms', 'digits_between:7,17'],
//            'country_code' => ['required_if:send_type,sms', 'exists:countries,code'],
//        ];
    }
}
