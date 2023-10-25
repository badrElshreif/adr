<?php

namespace App\HomeSlider\Domain\Services;

use App\HomeSlider\Domain\Models\HomeSlider;
use App\Infrastructure\Domain\Payloads\GenericPayload;
use App\Infrastructure\Domain\Services\Service;
use App\Infrastructure\Exceptions\ModelNotFoundException;
use Symfony\Component\HttpFoundation\Response;

class ShowSliderService extends Service
{
    public function handle($data = [])
    {
        try {
            $ad = HomeSlider::findOrFail($data['slider_id']);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $ex) {
            throw new ModelNotFoundException;
        } catch (Exception $ex) {
            return new GenericPayload(
                __('error.someThingWrong'), 422
            );
        }

        return new GenericPayload($ad, Response::HTTP_CREATED);

    }
}
