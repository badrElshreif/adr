<?php

namespace App\User\Domain\Services\Auth;

use App\Infrastructure\Domain\Payloads\GenericPayload;
use App\Infrastructure\Domain\Services\Service;
use App\Infrastructure\Exceptions\UserNotFoundException;
use App\Order\Domain\Models\Cart;
use App\Order\Domain\Models\OrderGift;
use App\User\Domain\Models\User;
use App\User\Domain\Resources\UserResource;
use Illuminate\Support\Arr;
use JWTAuth;
use Symfony\Component\HttpFoundation\Response;

class VerifyAccountService extends Service
{
    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function handle($data = null)
    {
        try {
//            if ($data['send_type'] == 'sms') {
            if (str_starts_with($data['phone'], '0')) {
                $data['phone'] = substr($data['phone'], 1, 20);
            }

            $user = $this->user->whereCountryCode($data['country_code'])->wherePhone($data['phone'])
                ->whereType($data['type'])->firstOrFail();
            // $user = $this->user->withTrashed()->whereCountryCode($data['country_code'])->wherePhone($data["phone"])
            //     ->whereType($data['type'])->firstOrFail();
//            }else{
//                $user = $this->user->whereEmail($data['email'])->firstOrFail();
//            }
            // if ($user->phone_verified_at != NULL)
            //     return new GenericPayload(
            //         __('error.alreadyVerifiedAccount'), 422
            //     );
            if ($user->verification_code == $data['code']) {
                $data['phone_verified_at'] = now();
                $data['is_active'] = 1;
                $data['verification_code'] = null;
                $user->update(Arr::only($data, ['phone_verified_at', 'is_active', 'verification_code']));
                $user->restore();
                $token = JWTAuth::fromUser($user);
                if (isset($data['device_token'])) {
                    $user->tokens()->firstOrCreate([
                        'device_token' => $data['device_token'],
                    ]);
                }

                // if(isset($data['device_id'])) {
                //     $cart = Cart::whereDeviceId($data['device_id'])->get();
                //     if(count($cart) > 0){
                //         foreach ($cart as $item) {
                //             $item->update([
                //                 'user_id' => $user->id,
                //                 'device_id' => null
                //             ]);
                //         }
                //     }
                // }

                // $gifts = OrderGift::wherePhone($data["phone"])->get();
                // if(count($gifts) > 0){
                //     foreach ($gifts as $gift) {
                //         $gift->update([
                //             'user_id' => $user->id
                //         ]);
                //     }
                // }
                if ($user->is_accepted == 1) {
                    $res = array_merge(
                        [
                            'message' => __('success.accountVerified'),
                            'user' => new UserResource($user),
                        ],
                        $this->respondWithToken($token)
                    );
                } else {
                    $res = [
                        'message' => __('success.accountVerified'),
                        'user' => new UserResource($user),
                    ];
                }

                return new GenericPayload($res, Response::HTTP_RESET_CONTENT);
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
