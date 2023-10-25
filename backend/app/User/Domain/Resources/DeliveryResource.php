<?php

namespace App\User\Domain\Resources;

use App\Location\Domain\Resources\CityLiteResource;
use Illuminate\Http\Resources\Json\JsonResource;

class DeliveryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $deliveryOrders = $this->user->deliveryOrders()
        ->whereHas('status', function ($q) {
            $q->whereIn('key', ['new', 'delayed','accepted', 'delivering', 'ready_for_delivery']);
        })->where('delivery_date_to', '>=', now())->get();
        $res = [
            'id'           => $this->user_id,
            'name'         => $this->user->name,
            'country_code' => $this->user->country_code,
            'phone'        => $this->user->phone,
            'email'        => $this->user->email,
            'gender'       => $this->user->gender,
            'avatar'       => $this->user->avatar,
            'type'         => $this->user->type,
            'is_active'    => $this->user->is_active,
        ];
            $res['latitude']                = $this->latitude;
            $res['longitude']               = $this->longitude;
            $res['city']                    = $this->city_id ? new CityLiteResource($this->city) : '';
            $res['wallet']                  = $this->wallet;
            $res['national_card_serial']    = $this->national_card_serial;
            $res['national_card_image']     = $this->national_card_image;
            $res['license_image']           = $this->license_image;
            $res['status']                  = $this->status;
            $res['vehicle_model']           = $this->vehicle_model;
            $res['vehicle_type']            = $this->vehicle_type;
            $res['vehicle_plate_number']    = $this->vehicle_plate_number;
            $res['bank_name']               = $this->bank_name;
            $res['iban_number']             = $this->iban_number;
            $res['bank_account']            = $this->bank_account;
            $res['stc_number']              = $this->stc_number;
            $res['wallet']                  = $this->wallet;
            $res['delivery_requests_count'] = $deliveryOrders->count() ?? 0;
            $res['delivery_requests_ids']   = $deliveryOrders->count() > 0 ? $deliveryOrders->implode('id', ',') : trans('admin.not_found');

        return $res;
    }
}
