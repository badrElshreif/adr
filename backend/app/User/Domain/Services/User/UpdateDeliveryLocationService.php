<?php

namespace App\User\Domain\Services\User;

use App\Infrastructure\Domain\Payloads\GenericPayload;
use App\Infrastructure\Domain\Services\Service;
use App\Infrastructure\Exceptions\UserNotFoundException;
use App\Order\Domain\Services\OrderHelperService;
use App\User\Domain\Models\User;
use Illuminate\Support\Arr;
use Symfony\Component\HttpFoundation\Response;
use DB;
class UpdateDeliveryLocationService extends Service
{
    public function handle($data = [])
    {
        try {
            DB::beginTransaction();
            $user             = auth('api')->user();
            $data['city_id']  = app(OrderHelperService::class)->getStoreCityId($data['latitude'], $data['longitude']);
            $user->delivery()->update(Arr::only($data, ['latitude', 'longitude', 'city_id']));
            call_location_map_event(null, $data['city_id']);

            DB::commit();
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $ex) {
            DB::rollBack();
            throw new UserNotFoundException;
        } catch (Exception $ex) {
            DB::rollBack();
            return new GenericPayload(
                 __('error.someThingWrong'), 422
            );
        }

        return new GenericPayload($user, Response::HTTP_CREATED);

    }
}
