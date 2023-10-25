<?php

namespace App\AppContent\Domain\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CountrySettingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {

        return [
            'id'         => $this->id,
            'name'       => $this->name,
            'code'       => $this->code,
            'sort'       => $this->sort,
            'phone_code' => $this->phone_code,
            'flag'       => $this->flag,
            'is_active'  => $this->is_active,
            'created_at' => \Carbon\Carbon::parse($this->created_at)->translatedFormat('d M Y'),
            'settings'   => SettingLiteResource::collection($this->whenLoaded('settings')),
        ];

    }
}
