<?php

namespace App\User\Domain\Services\User;

use App\Infrastructure\Domain\Payloads\GenericPayload;
use App\Infrastructure\Domain\Services\Service;
use App\User\Domain\Models\User;
use App\User\Domain\Resources\UserResource;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class UpdateUserProfileService extends Service
{
    public function handle($data = [])
    {
        //upload image
        $user = auth()->user();
        // if(isset($data['avatar'])) {
        //     if($user->avatar)
        //         $this->deleteFile($user->avatar, 'user/avatar');
        // }

        if (isset($data['phone']) || isset($data['country_code'])) {

            $data['phone'] = isset($data['phone']) ? $data['phone'] : $user->phone;
            $data['country_code'] = isset($data['country_code']) ? $data['country_code'] : $user->country_code;

            if (str_starts_with($data['phone'], '0')) {
                $data['phone'] = substr($data['phone'], 1, 20);
            }

            if ($data['phone'] != $user->phone || $data['country_code'] != $user->country_code) {
                $check_phone = User::wherePhone($data['phone'])->whereCountryCode($data['country_code'])->where('id', '!=', $user->id)->whereType($user->type)->first();
                if ($check_phone) {
                    return new GenericPayload(
                         __('error.phoneExist'), 422
                    );
                }
                $check_user_phone = User::whereCountryCode($data['country_code'])->wherePhone($data['phone'])->where('phone', '!=', $user->phone)->whereType($user->type)->first();
                if ($check_user_phone) {
                    return new GenericPayload(__('error.duplicatePhone'), 422
                        );
                }
//send sms
                if ($user->phone != $data['phone'] || $data['country_code'] != $user->country_code) {
                    $data['updated_phone']        = $data['phone'];
                    $data['updated_country_code'] = $data['country_code'];
                    $data['phone_updated_at']     = null;
                    $data['verification_code']    = rand(1111, 9999);
                          $message                = __('general.sms.phoneVerificationCode').$data['verification_code'];
                    sendSMS($data['country_code'].$data['phone'], $message);
                }
            }

        }
        DB::beginTransaction();
        $user->update(Arr::only($data, ['name', 'email', 'avatar', 'gender', 'phone_updated_at', 'verification_code', 'updated_phone', 'updated_country_code']));
        if ($user->type == 'delivery') {
            $user->delivery()->update(Arr::except($data, ['phone', 'status','country_code', 'name', 'email', 'avatar', 'country_code', 'gender', 'phone_updated_at', 'verification_code', 'updated_phone', 'updated_country_code']));
            if(isset($data['status'])) {
                $status = $user->delivery->status;
                if($data['status'] != $status) {
                    call_location_map_event(null, $user?->delivery?->city_id);
                }
            }
        }
        DB::commit();
        $res['user'] = new UserResource($user);

        $res['phone_updated'] = ((isset($data['phone']) || isset($data['country_code'])) && (($user->phone != $data['phone'] ?? '') || $user->country_code != $data['country_code'])) ? true : false;

        return new GenericPayload($res, Response::HTTP_RESET_CONTENT);
    }
}
