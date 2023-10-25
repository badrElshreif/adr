<?php

namespace App\User\Domain\Services\User;

use App\Infrastructure\Domain\Payloads\GenericPayload;
use App\Infrastructure\Domain\Services\Service;
use App\Infrastructure\Exceptions\UserNotFoundException;
use App\User\Domain\Models\User;
use DB;
use Symfony\Component\HttpFoundation\Response;

class ToggleUserStatusService extends Service
{
    public function handle($data = [])
    {
        try {
            // Begin Transaction
            DB::beginTransaction();
            $user = User::findOrFail($data['user_id']);
            if ($user->is_active == 1) {
                $user->statuses()->create([
                    'reason' => $data['reason'],
                    'status' => 'in active',
                ]);
            }
            $user->update([
                'is_active' => ! $user->is_active,
            ]);
            DB::commit();
            if ($user->is_active == 1) {
                $message = trans('general.activation_message');
                 $title = trans('general.activation_title');
            } else {
                $message = trans('general.account_inactive_message').' '.$data['reason'];
                 $title = trans('general.account_inactive_title');
            }
            \Mail::to($user->email)->send(new \App\Admin\Domain\Mail\StatusMail($message, $title));
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $ex) {
            // Rollback Transaction
            DB::rollback();
            throw new UserNotFoundException;
        } catch (Exception $ex) {
            // Rollback Transaction
            DB::rollback();

            return new GenericPayload(
                __('error.someThingWrong'), 422
            );
        }

        return new GenericPayload($user, Response::HTTP_CREATED);

    }
}
