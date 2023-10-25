<?php

namespace App\Admin\Domain\Services\Auth;

use App\Admin\Domain\Resources\AdminLiteResource;
use App\Infrastructure\Domain\Payloads\GenericPayload;
use App\Infrastructure\Domain\Services\Service;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use JWTAuth;

class LoginAdminService extends Service
{
    public function __construct()
    {
        Auth::setDefaultDriver('admins');
        Auth::shouldUse('admin');
    }

    public function handle($data = [])
    {
        try {
            $rememberMe = boolval(Arr::has($data, 'remember_me') ? Arr::get($data, 'remember_me') : false);
            $loginData  = Arr::only($data, ['email', 'password']);

            if ($token = JWTAuth::attempt($loginData, $rememberMe))
            {

                if (! Auth::user('admin')->is_active)
                {
                    return new GenericPayload(__('error.inActiveUser'), 425
                    );
                }

                $this->incrementLoginNum();

                if (isset($data['device_token']))
                {
                    Auth::user('admin')->tokens()->firstOrCreate([
                        'device_token' => $data['device_token']
                    ]);
                }

                return new GenericPayload($this->respondWithToken($token));
            }

            //return new GenericPayload( __('error.wrongPassword'), 422);
            return new GenericPayload(__('error.wrongLoginData'), 422);

        }
        catch (ArgumentCountError $ex)
        {
            return new GenericPayload(
                ('error.someThingWrong'), 422
            );
        }
        catch (Exception $ex)
        {
            return new GenericPayload(
                ('error.someThingWrong'), 422
            );
        }

    }

    private function incrementLoginNum()
    {
        auth()->user()->increment('login_numbers', 1, ['last_login_at' => Carbon::now()]);
    }

    /**
     * Get the token array structure.
     *
     * @param  string  $token
     * @return array
     */
    protected function respondWithToken($token): array {
        return [
            'access_token' => $token,
            'token_type'   => 'bearer',
            'expires_in'   => auth()->factory()->getTTL() * 60,
            'user'         => new AdminLiteResource(auth()->user('admin'))
        ];
    }

}
