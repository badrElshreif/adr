<?php

namespace App\Admin\Domain\Services\Auth;

use App\Admin\Domain\Models\Admin;
use App\Infrastructure\Domain\Models\PasswordReset;
use App\Infrastructure\Domain\Payloads\GenericPayload;
use App\Infrastructure\Domain\Services\Service;
use App\Infrastructure\Exceptions\UserNotFoundException;
use Carbon\Carbon;

class ForgetPasswordService extends Service
{
    public function __construct()
    {

    }

    public function handle($data = [])
    {
        try {

            $admin = Admin::whereEmail($data['email'])
                ->whereNull('company_id')
                ->firstOrFail();

            if ($admin->is_active == 1)
            {
                $token = rand(1111, 9999);
                PasswordReset::updateOrCreate(
                    ['phone' => $admin->email], ['token' => $token, 'created_at' => Carbon::now()]
                );

                if (app()->getLocale() == 'en')
                {
                    $message = "According your request to reset password ,Code is {$token} use it , if you didn't ask ignore it";
                }
                else
                {
                    $message = "بنــــاء ع طلبكم تغيير كلمة المرور استخدم كود  {$token} يرجى التجاهل في حالة عدم الطلب";
                }

                //send email to school
                \Mail::to($admin->email)->send(new \App\Admin\Domain\Mail\ForgetPasswordMail($message));

                return new GenericPayload(
                    [
                        'message' => __('success.TokenSentToEmail'),
                        'code'    => $token
                    ]
                );
            }

            return new GenericPayload(
                __('error.accountNotActivated'), 425
            );

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
