<?php

namespace App\AppContent\Domain\Services\Setting;

use App\Infrastructure\Domain\Payloads\GenericPayload;
use App\Infrastructure\Domain\Services\Service;
use App\Location\Domain\Filters\CountryFilter;
use App\Location\Domain\Models\Country;
use Symfony\Component\HttpFoundation\Response;

class DeleteCountriesSettingsService extends Service
{

    protected $country;


    public function __construct(Country $country)
    {
        $this->country = $country;
    }

    public function handle($data = [])
    {
        try {
            $country = $this->country->where('id', $data['country_id'])->first();
            if($country->settings) {
                $country->settings()->delete();
            }
            return new GenericPayload(['message' => __('success.deletedSuccessfuly')], Response::HTTP_NO_CONTENT);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $ex) {
            throw new ModelNotFoundException;
        } catch (Exception $ex) {
            return new GenericPayload(
                __('error.someThingWrong'), 422
            );
        }

    }
}
