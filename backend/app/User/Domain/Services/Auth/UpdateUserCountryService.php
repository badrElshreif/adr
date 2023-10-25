<?php

namespace App\User\Domain\Services\Auth;

use App\Infrastructure\Domain\Payloads\GenericPayload;
use App\Infrastructure\Domain\Services\Service;
use App\User\Domain\Models\User;
use Symfony\Component\HttpFoundation\Response;

class UpdateUserCountryService extends Service
{
    public function handle($data)
    {
        try {

            if (auth()->check() && isset($data['country_id']))
            {
                auth()->user()->update(['country_id' => $data['country_id']]);
            }

            $user = User::find(auth()->user()->id);

            return new GenericPayload($user, Response::HTTP_CREATED);
        }
        catch (Exception $ex)
        {
            return new GenericPayload(
                __('error.someThingWrong'), 422
            );
        }

    }

}
