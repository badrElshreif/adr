<?php

namespace App\AppContent\Domain\Resources;

use App\Location\Domain\Resources\CountryLiteResource;
use App\Property\Domain\Resources\PropertyTypeResource;
use Illuminate\Http\Resources\Json\JsonResource;

class SettingLiteResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $resource = [
            'key' => $this->key,
            'body' => $this->body,
        ];
        if (auth()->guard('admin')->check()) {
            return array_merge($resource, [
                // 'id' => $this->id,
                'name'       => $this->name,
                'hint'       => $this->hint,
                //'is_active' => $this->is_active,
                'property_type' => new PropertyTypeResource($this->propertyType),
            ]);
        }

        return $resource;
    }
}
