<?php

namespace App\Notification\Domain\Services;

use App\Company\Domain\Models\CompanyAdmin;
use App\Infrastructure\Domain\Payloads\GenericPayload;
use App\Infrastructure\Domain\Services\Service;
use App\Notification\Domain\Notifications\GeneralNotification;
use App\User\Domain\Models\User;
use Illuminate\Support\Facades\Notification;
use Symfony\Component\HttpFoundation\Response;

class SendNotificationService extends Service
{
    public function handle($data = [])
    {
        try {
            $locale = app()->getLocale();

            if (isset($data['type']) && $data['type'] == 'store')
            {
                $admins  = CompanyAdmin::whereIsActive(1)->where('company_id', $data['company_id'])->get();
                $message = [
                    'title' => $data[$locale]['title'],
                    'body'  => $data[$locale]['body'],
                    'type'  => 'dashboard'
                ];
                $tokens = \App\User\Domain\Models\DeviceToken::where('tokenable_type', 'App\Company\Domain\Models\CompanyAdmin')
                    ->whereIn('tokenable_id', CompanyAdmin::whereIsActive(1)->where('company_id', $data['company_id'])->pluck('id')->toArray())->pluck('id')->all();

                if (count($admins) > 0)
                {
                    send_fcm_notification(
                        $admins,
                        $message,
                        true,
                        $tokens,
                    );
                    Notification::send($admins, new GeneralNotification(array_merge($data, [
                        'type' => 'dashboard'
                    ])));
                }

// foreach($admins as $admin) {

//     \Mail::send('emails.send_mail', ['data' => $message, 'admin' => $admin], function ($message) use ($admin) {

//         $message->to($admin->email)->subject('Store Notification');

//         $message->from('admin@yaa.world');

//     });
                // }
            }
            else
            {
                $users = User::whereIsActive(1)->get();

                if (count($users) > 0)
                {
                    $tokens = \App\User\Domain\Models\DeviceToken::where('tokenable_type', 'App\User\Domain\Models\User')
                        ->whereIn('tokenable_id', User::whereIsActive(1)->pluck('id')->toArray())->pluck('device_token')->all();
                    send_fcm_notification(
                        $tokens,
                        [
                            'title' => $data[$locale]['title'],
                            'body'  => $data[$locale]['body'],
                            'type'  => 'dashboard'
                        ],
                        false, [''],
                        'notification'
                    );
                    Notification::send($users, new GeneralNotification(array_merge($data, [
                        'type' => 'dashboard'
                    ])));
                }

            }

            return new GenericPayload(['message' => __('success.sentSuccessfully')], Response::HTTP_RESET_CONTENT);
        }
        catch (Exception $ex)
        {
            return new GenericPayload(
                ['message' => __('error.someThingWrong')], 422
            );
        }

    }

}
