<?php

namespace App\User\Domain\Services\User;

use App\Infrastructure\Domain\Payloads\GenericPayload;
use App\Infrastructure\Domain\Services\Service;
use App\Infrastructure\Exceptions\UserNotFoundException;
use App\User\Domain\Models\User;
use DB;
use Symfony\Component\HttpFoundation\Response;

class AcceptRejectDeliveryService extends Service
{
    public function handle($data = [])
    {
        try {
            // Begin Transaction
            DB::beginTransaction();
            $user = User::findOrFail($data['user_id']);
            if ($data['status'] == 1) {
                $user->update([
                    'is_accepted' => 1,
                ]);
            } else {
                $user->update([
                    'is_accepted' => 2,
                    'rejection_reason' => $data['rejection_reason'],
                ]);
            }
            DB::commit();
            if ($user->is_accepted == 1) {
                $message = trans('general.accept_delivery');
                $title = trans('general.accept_title');

            } else {
                $message = trans('general.reject_delivery').' '.$data['rejection_reason'];
                $title = trans('general.reject_title');
            }
            \Mail::to($user->email)->send(new \App\Admin\Domain\Mail\StatusMail($message, $title));
            if ($user->is_accepted == 2) {
                $user->delete();
            }
            call_location_map_event(null, $user?->delivery?->city_id);

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

        return new GenericPayload(['message' => __('success.updatedSuccessfuly')], Response::HTTP_NO_CONTENT
        );

    }
}
