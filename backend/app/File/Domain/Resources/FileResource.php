<?php

namespace App\File\Domain\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FileResource extends JsonResource
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
            'id'                      => $this->id,
            'name'                    => $this->name,
            'ar'                      => optional($this->translate('ar'))->only('name', 'description'),
            'en'                      => optional($this->translate('en'))->only('name', 'description'),
            'image'                   => $this->image,
            // 'order'                   => $this->order,
            'type'                    => $this->type,
            'is_active'               => $this->is_active,
            'password'                => $this->password,
            'status'                  => $this->status,
            'appear_for_free_package' => $this->appear_for_free_package,
            'created_at'              => \Carbon\Carbon::parse($this->created_at)->translatedFormat('d M Y')
        ];
        return $resource;
    }
}
