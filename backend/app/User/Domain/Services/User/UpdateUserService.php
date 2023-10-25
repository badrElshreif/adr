<?php

namespace App\User\Domain\Services\User;

use App\Infrastructure\Domain\Payloads\GenericPayload;
use App\Infrastructure\Domain\Services\Service;
use App\Infrastructure\Exceptions\UserNotFoundException;
use App\User\Domain\Models\User;
use Illuminate\Support\Arr;
use Symfony\Component\HttpFoundation\Response;

class UpdateUserService extends Service
{
    public function handle($data = [])
    {
        try {
            $user = User::findOrFail($data['user_id']);
            if (isset($data['phone']) || isset($data['country_code'])) {
                $data['phone'] = isset($data['phone']) ? $data['phone'] : $user->phone;
                $data['country_code'] = isset($data['country_code']) ? $data['country_code'] : $user->country_code;

                if (str_starts_with($data['phone'], '0')) {
                    $data['phone'] = substr($data['phone'], 1, 20);
                }

                if ($data['phone'] != $user->phone) {
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
                }
            }
            $user->update(Arr::only($data, ['phone', 'name', 'email', 'avatar', 'country_code', 'gender', 'phone_updated_at', 'verification_code', 'updated_phone']));
            if ($user->type == 'delivery') {
                $user->delivery()->update(Arr::except($data, ['phone', 'name', 'email', 'avatar', 'country_code', 'gender', 'phone_updated_at', 'verification_code', 'updated_phone']));
            }
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $ex) {
            throw new UserNotFoundException;
        } catch (Exception $ex) {
            return new GenericPayload(
                 __('error.someThingWrong'), 422
            );
        }

        return new GenericPayload($user, Response::HTTP_CREATED);

    }
}
