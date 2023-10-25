<?php

namespace App\AppContent\Domain\Services\Setting;

use App\AppContent\Domain\Models\Setting;
use App\Infrastructure\Domain\Payloads\GenericPayload;
use App\Infrastructure\Domain\Services\Service;
use Symfony\Component\HttpFoundation\Response;

class GetSettingsService extends Service
{
    public function handle($data = [])
    {
        try {
            $target = 'superAdmin';

            if (isset($data['target']) && ! auth()->check())
            {
                $target = $data['target'];
            }
            else
            {

                if (optional(auth()->user())->company_id != null)
                {

                    if (optional(auth()->user()->company)->type == 'company')
                    {
                        $target = 'company';
                    }
                    else
                    {
                        $target = 'companies';
                    }

                }

            }

            $settings = Setting::with(['country', 'propertyType'])->whereTarget($target)->whereIsActive(1)->orderBy('id', 'asc')->get();

            return new GenericPayload($settings, Response::HTTP_OK);
        }
        catch (\Exception $ex)
        {
            return new GenericPayload(
                ['message' => __('error.someThingWrong')], 422
            );
        }

    }

}
