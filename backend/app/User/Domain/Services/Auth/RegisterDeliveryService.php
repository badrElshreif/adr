<?php

namespace App\User\Domain\Services\Auth;

use App\Infrastructure\Domain\Payloads\GenericPayload;
use App\Infrastructure\Domain\Services\Service;
use App\User\Domain\Models\User;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class RegisterDeliveryService extends Service
{
    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function handle($data = [])
    {
        $data['password']          = Hash::make($data['password']);
        $data['type']              = 'delivery';
        $data['verification_code'] = rand(1111, 9999);
        if (auth('admin')->check()) {
            $data['is_accepted'] = 1;
        } else {
            $data['is_accepted'] = 0;
        }
        if (str_starts_with($data['phone'], '0')) {
            $data['phone'] = substr($data['phone'], 1, 20);
        }
        DB::beginTransaction();
        $check_user_phone = User::withTrashed()->wherePhone($data['phone'])->whereCountryCode($data['country_code'])
            ->whereType('delivery')->first();

        if ($check_user_phone && $check_user_phone->deleted_at == null) {
            return new GenericPayload(__('error.duplicatePhone'), 422);
        }
        if ($check_user_phone && $check_user_phone->deleted_at) {
            $check_user_phone->update(array_merge($data, ['phone_verified_at' => null, 'deleted_at' => null]));
            $check_user_phone->delivery()->update(
                Arr::only($data, [
                'latitude',
                'longitude',
                'address',
                'city_id',
                'national_card_serial',
                'national_card_image',
                'license_image',
                'vehicle_model',
                'vehicle_type',
                'vehicle_plate_number',
                'bank_name',
                'iban_number',
                'bank_account',
                'stc_number'
            ]));
        } else {
            $user = $this->user->create($data);
            $user->delivery()->create($data);
        }
        DB::commit();
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
