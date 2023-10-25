<?php

namespace App\HomeSlider\Domain\Services;

use App\HomeSlider\Domain\Models\HomeSlider;
use App\Infrastructure\Domain\Payloads\GenericPayload;
use App\Infrastructure\Domain\Services\Service;
use App\Infrastructure\Exceptions\ModelNotFoundException;
use Symfony\Component\HttpFoundation\Response;

class ToggleSliderStatusService extends Service
{
    public function handle($data = [])
    {
        try {
            $ad = HomeSlider::findOrFail($data['slider_id']);
            if (HomeSlider::where('is_active', 1)->count() <= 1 && $ad->is_active) {
                return new GenericPayload(
                    __('admin.there_should_one_at_least'), 422
                );
            } else {
                $ad->update([
                    'is_active' => ! $ad->is_active,
                ]);
            }
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $ex) {
            throw new ModelNotFoundException;
        } catch (\Illuminate\Database\QueryException $ex) {
            // Rollback Transaction
            DB::rollback();

            return new GenericPayload(
                __('error.someThingWrong'), 422
            );
        } catch (\PDOException $ex) {
            // Rollback Transaction
            DB::rollback();

            return new GenericPayload(
                __('error.someThingWrong'), 422
            );
        } catch (\Exception $ex) {
            // Rollback Transaction
            DB::rollback();

            return new GenericPayload(
                __('error.someThingWrong'), 422
            );
        }

        return new GenericPayload($ad, Response::HTTP_CREATED);

    }
}
