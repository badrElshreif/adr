<?php

namespace App\User\Domain\Services\User;

use App\Infrastructure\Domain\Payloads\GenericPayload;
use App\Infrastructure\Domain\Services\Service;
use App\Infrastructure\Exceptions\UserNotFoundException;
use App\User\Domain\Models\User;
use Illuminate\Support\Arr;
use Symfony\Component\HttpFoundation\Response;

class UpdatePhoneService extends Service
{
    public function handle($data = [])
    {
        try {
            if (str_starts_with($data['phone'], '0')) {
                $data['phone'] = substr($data['phone'], 1, 20);
            }

            $user = auth()->user();
            if ($user->phone_updated_at != null && $user->update_country_code != null && $user->phone == $data['phone'] && $user->country_code == $data['country_code']) {
                return new GenericPayload(
                     __('error.alreadyVerifiedPhone'), 422
                );
            }
            if ($data['phone'] != $user->updated_phone || $data['country_code'] != $user->updated_country_code) {
                return new GenericPayload(
                     __('error.wrongPhone'), 422
                );
            }
            if ($user->verification_code == $data['code']) {
                $data['phone_updated_at'] = now();
                $data['verification_code'] = null;
                $data['updated_phone'] = null;
                $data['updated_country_code'] = null;

                $check_user_phone = User::whereCountryCode($data['country_code'])->wherePhone($data['phone'])
                    ->whereType($user->type)->first();
                if ($check_user_phone) {
                    return new GenericPayload(__('error.duplicatePhone'), 422
                        );
                }

                $user->update(Arr::only($data, ['phone_updated_at', 'update_country_code', 'country_code', 'phone', 'verification_code', 'updated_phone']));

                return new GenericPayload($user, Response::HTTP_CREATED);
            }

            return new GenericPayload(
                __('error.invalidCode'), 422
            );
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $ex) {
            throw new UserNotFoundException;
        } catch (Exception $ex) {
            return new GenericPayload(
                __('error.someThingWrong'), 422
            );
        }
    }
}
