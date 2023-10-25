<?php

namespace App\User\Domain\Services\Auth;

use App\Infrastructure\Domain\Payloads\GenericPayload;
use App\Infrastructure\Domain\Services\Service;
use App\User\Domain\Models\User;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class RegisterUserService extends Service
{
    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function handle($data = [])
    {
        $data['password']          = Hash::make($data['password']);
        $data['verification_code'] = rand(1111, 9999);
        if (str_starts_with($data['phone'], '0')) {
            $data['phone'] = substr($data['phone'], 1, 20);
        }

        $check_user_phone = User::withTrashed()->wherePhone($data['phone'])->whereCountryCode($data['country_code'])
            ->whereType('client')->first();

        if ($check_user_phone && $check_user_phone->deleted_at == null) {
            return new GenericPayload(__('error.duplicatePhone'), 422);
        }

        if ($check_user_phone && $check_user_phone->deleted_at) {
            $check_user_phone->update(array_merge($data,['phone_verified_at'=>null]));
          //  $user = $this->user->create($data);
        } else {
            $user = $this->user->create($data);
        }
        $message = __('general.sms.phoneVerificationCode').$data['verification_code'];
        sendSMS($data['country_code'].$data['phone'], $message);

//        if ($data['send_type'] == 'sms') {
//            sendSMS($data['country_code'] . $data['phone'], $message);
//        } else {
//            \Mail::to($user->email)->send(new \App\Admin\Domain\Mail\ForgetPasswordMail($message));
//        }
        //$user = $this->user->create(Arr::only($data, ["name", "email", "password", "is_active"]));
        return new GenericPayload(
            [
                'message' => __('success.successfullyRegistered'),
                //'code'    => $user->verification_code
            ],
            Response::HTTP_RESET_CONTENT
        );
    }
}
