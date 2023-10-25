<?php

namespace App\AppContent\Domain\Resources;

use App\Property\Domain\Resources\PropertyTypeResource;
use Illuminate\Http\Resources\Json\JsonResource;

class SettingResource extends JsonResource
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
            'key'  => $this->key,
            'body' => $this->body
        ];

        if (auth()->guard('admin')->check())
        {
            return array_merge($resource, [
                'name'          => $this->name,
                'hint'          => $this->hint,
                'property_type' => new PropertyTypeResource($this->propertyType)
            ]);
        }

        return $resource;
    }

}
