<?php

namespace App\AppContent\Domain\Services\Setting;

use App\AppContent\Domain\Models\Setting;
use App\AppContent\Domain\Resources\SettingResource;
use App\Infrastructure\Domain\Payloads\GenericPayload;
use App\Infrastructure\Domain\Services\Service;
use App\Location\Domain\Models\Country;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class GenerateSettingsService extends Service
{
    public function handle($data = [])
    {
        try {
            DB::beginTransaction();
            cache()->forget('settings');
            $msg = __('success.updatedSuccessfuly');
            if (isset($data['country_id'])) {
                $country = Country::whereDoesntHave('settings')->where('id', $data['country_id'])->first();
                if(!$country) {
                    DB::rollBack();
                    return new GenericPayload(
                        __('error.This_country_already_has_the_settings'), 422
                    );
                }
                foreach(settings_country($country->id) as $setting) {
                    Setting::firstOrCreate(
                        [
                            'key'        => $setting['key'],
                            'country_id' => $country->id,
                        ],
                        $setting
                    );
                }
            }


            DB::commit();
            return new GenericPayload(['message' => $msg], Response::HTTP_RESET_CONTENT);
            // return new GenericPayload(['message' => $msg , 'settings' => SettingResource::collection(Setting::whereTarget($target)->get())], Response::HTTP_RESET_CONTENT);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $ex) {
            throw new ModelNotFoundException;
        } catch (Exception $ex) {
            return new GenericPayload(
                __('error.someThingWrong'), 422
            );
        }

    }
}
