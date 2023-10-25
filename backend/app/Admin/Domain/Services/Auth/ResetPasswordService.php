<?php

namespace App\Admin\Domain\Services\Auth;

use App\Admin\Domain\Models\Admin;
use App\Infrastructure\Domain\Models\PasswordReset;
use App\Infrastructure\Domain\Payloads\GenericPayload;
use App\Infrastructure\Domain\Services\Service;
use App\Infrastructure\Exceptions\UserNotFoundException;
use Illuminate\Support\Facades\Hash;

class ResetPasswordService extends Service
{
    public function __construct()
    {

    }

    public function handle($data = [])
    {
        try {
            $admin       = Admin::whereEmail($data['email'])->firstOrFail();
            $check_token = PasswordReset::where(['phone' => $data['email'], 'token' => $data['code']])->first();

            if (! $check_token)
            {
                return new GenericPayload(
                    __('error.invalidCode'), 422
                );
            }

            $admin->update(['password' => Hash::make($data['password'])]);
            $check_token->delete();

            return new GenericPayload(['message' => __('success.PasswordChanged')]);

        }
        catch (\Illuminate\Database\Eloquent\ModelNotFoundException $ex)
        {
            throw new UserNotFoundException;
        }
        catch (Exception $ex)
        {
            return new GenericPayload(
                __('error.someThingWrong'), 422
            );
        }

    }

}
