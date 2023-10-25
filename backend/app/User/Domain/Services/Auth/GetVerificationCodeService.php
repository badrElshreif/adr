<?php

namespace App\User\Domain\Services\Auth;

use App\Infrastructure\Domain\Payloads\GenericPayload;
use App\Infrastructure\Domain\Services\Service;
use App\Infrastructure\Exceptions\UserNotFoundException;
use App\User\Domain\Models\User;
use Symfony\Component\HttpFoundation\Response;

class GetVerificationCodeService extends Service
{
    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function handle($data = null)
    {
        try {
//            if($data['send_type']=='sms'){
            if (str_starts_with($data['phone'], '0')) {
                $data['phone'] = substr($data['phone'], 1, 20);
            }
            $user = $this->user->whereCountryCode($data['country_code'])->wherePhone($data['phone'])
                ->whereType($data['type'])->firstOrFail();
//            }else{
//                $user = $this->user->whereEmail($data['email'])->firstOrFail();
//            }
            //resend verification code
            return new GenericPayload(
                [
                    'code' => $user->verification_code,
                ],
                Response::HTTP_RESET_CONTENT
            );
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $ex) {
            throw new UserNotFoundException;
        } catch (Exception $ex) {
            return new GenericPayload(
                __('error.someThingWrong'), 422
            );
        }
    }

    /**
     * Get the token array structure.
     *
     * @param  string  $token
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return [
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
        ];
    }
}
