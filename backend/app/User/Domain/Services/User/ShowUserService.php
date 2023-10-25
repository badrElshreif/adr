<?php

namespace App\User\Domain\Services\User;

use App\Infrastructure\Domain\Payloads\GenericPayload;
use App\Infrastructure\Domain\Services\Service;
use App\Infrastructure\Exceptions\UserNotFoundException;
use App\User\Domain\Models\User;
use Symfony\Component\HttpFoundation\Response;

class ShowUserService extends Service
{
    public function handle($data = [])
    {
        try {
            $user = User::findOrFail($data['user_id']);

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
