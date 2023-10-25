<?php

namespace App\AppContent\Domain\Services\Setting;

use App\AppContent\Domain\Models\Setting;
use App\Infrastructure\Domain\Payloads\GenericPayload;
use App\Infrastructure\Domain\Services\Service;
use App\Location\Domain\Filters\CountryFilter;
use App\Location\Domain\Models\Country;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class CountriesSettingService extends Service
{

    protected $country;

    protected $filter;

    public function __construct(Country $country, CountryFilter $filter)
    {
        $this->country = $country;
        $this->filter = $filter;
    }
    public function handle($data = [])
    {
        try {
            $countries = $this->country
            ->filter($this->filter)
            ->with('translations', 'settings.propertyType.translations')
            ->whereNull('deleted_at')
            ->whereIsActive(1)
            ->orderBy('sort', 'ASC')->paginate(20);

            return new GenericPayload($countries, Response::HTTP_ACCEPTED);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $ex) {
            throw new ModelNotFoundException;
        } catch (Exception $ex) {
            return new GenericPayload(
                __('error.someThingWrong'), 422
            );
        }

    }
}
