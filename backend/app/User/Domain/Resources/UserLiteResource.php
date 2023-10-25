<?php

namespace App\User\Domain\Resources;

use App\Location\Domain\Resources\CityLiteResource;
use Illuminate\Http\Resources\Json\JsonResource;

class UserLiteResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return array_merge([
            'id'                => $this->id,
            'name'              => $this->name,
            'country_code'      => $this->country_code,
            'phone'             => $this->phone,
            'email'             => $this->email,
            'avatar'            => $this->avatar,
            'currency'          => $this->country?->currency,
            'type'              => $this->type,
            'city'              => $this->type == 'delivery' && @$this->delivery->city_id ? new CityLiteResource($this->delivery->city) : '',
            'latitude'          => $this->delivery ? $this->delivery->latitude : null,
            'longitude'         => $this->delivery ? $this->delivery->longitude : null,
            'is_active'         => $this->is_active,
            'is_verified'       => $this->phone_verified_at ? true : false,
            'created_at'        => \Carbon\Carbon::parse($this->created_at)->translatedFormat('d M Y'),
            'verification_code' => $this->verification_code ?: ''
        ]);
    }
}
