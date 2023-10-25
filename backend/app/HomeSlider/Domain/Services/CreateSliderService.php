<?php

namespace App\HomeSlider\Domain\Services;

use App\HomeSlider\Domain\Models\HomeSlider;
use App\Infrastructure\Domain\Payloads\GenericPayload;
use App\Infrastructure\Domain\Services\Service;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class CreateSliderService extends Service
{
    public function handle($data = [])
    {
        try {
            // Begin Transaction
            DB::beginTransaction();
            $data['is_active'] = isset($data['is_active']) ? isset($data['is_active']) : 1;
            $ad = HomeSlider::create($data);
            // Commit Transaction
            DB::commit();

            return new GenericPayload($ad, Response::HTTP_CREATED);

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

    }
}
