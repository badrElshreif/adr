<?php

namespace App\User\Domain\Services\Auth;

use App\Infrastructure\Domain\Payloads\GenericPayload;
use App\Infrastructure\Domain\Services\Service;
use App\User\Domain\Models\User;
use Symfony\Component\HttpFoundation\Response;

class DeleteAccountService extends Service
{
    public function handle($data = [])
    {
        try {
            if ((float) (optional(auth()->user()->transactions()->orderBy('id', 'desc')->first())->wallet_total ?? 0) < 0) {
                return new GenericPayload(__('error.pay_before_delete'), 422);
            }
            auth()->user()->tokens()->delete();
//	        optional(auth()->user()->tokens)->delete();
            $id = auth('api')->id();
            auth('api')->logout();
            User::where('id', $id)->delete();

            return new GenericPayload(['message' => __('success.deletedSuccessfuly')], Response::HTTP_NO_CONTENT);
        } catch (Exception $ex) {
            return new GenericPayload(
                __('error.someThingWrong'), 422
            );
        }

    }
}
