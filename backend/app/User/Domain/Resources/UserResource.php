<?php

namespace App\User\Domain\Resources;

use App\Location\Domain\Resources\CityLiteResource;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $res = [
            'id'                => $this->id,
            'name'              => $this->name,
            'country_code'      => $this->country_code,
            'phone'             => $this->phone,
            'email'             => $this->email,
            'gender'            => $this->gender,
            'avatar'            => $this->avatar,
            'type'              => $this->type,
            'currency'          => $this->country?->currency,

//            'latitude' => $this->latitude,
            //            'longitude' => $this->longitude,
            'is_active'         => $this->is_active,
            //            'orders_count' => $this->orders_count,
            'wallet'            => round(optional($this->transactions()->orderBy('id', 'desc')->first())->wallet_total, 2) ?: 0.00,
            'last_login_at'     => \Carbon\Carbon::parse($this->last_login_at)->translatedFormat('d M Y'),
            'addresses'         => UserAddressResource::collection($this->addresses),
            'verification_code' => $this->verification_code,
            'is_verified'       => $this->phone_verified_at ? true : false,
            'created_at'        => \Carbon\Carbon::parse($this->created_at)->translatedFormat('d M Y')
            //'firebaseTokens' => $this->tokens->pluck('device_token')->all()
        ];

        if ($this->type == 'delivery')
        {
            $rate                        = $this->deliveryRatings->where('is_active', 1)->avg('rate');
            $res['address']              = $this->delivery->address;
            $res['latitude']             = $this->delivery->latitude;
            $res['longitude']            = $this->delivery->longitude;
            $res['city']                 = $this->delivery->city_id ? new CityLiteResource($this->delivery->city) : '';
            $res['wallet']               = $this->delivery->wallet;
            $res['national_card_serial'] = $this->delivery->national_card_serial;
            $res['national_card_image']  = $this->delivery->national_card_image;
            $res['license_image']        = $this->delivery->license_image;
            $res['status']               = $this->delivery->status;
            $res['vehicle_model']        = $this->delivery->vehicle_model;
            $res['vehicle_type']         = $this->delivery->vehicle_type;
            $res['vehicle_plate_number'] = $this->delivery->vehicle_plate_number;
            $res['bank_name']            = $this->delivery->bank_name;
            $res['iban_number']          = $this->delivery->iban_number;
            $res['bank_account']         = $this->delivery->bank_account;
            $res['stc_number']           = $this->delivery->stc_number;
            $res['rate']                 = number_format($rate, 2);
            $res['rating_users_no']      = $this->deliveryRatings->where('status_id', null)->where('is_active', 1)->count('user_id');
        }

//substr(string,start,length)

// $country_code_length = strlen($this->country_code);;
        // $phone = substr($this->phone,$country_code_length,20);

        return $res;
    }

}
