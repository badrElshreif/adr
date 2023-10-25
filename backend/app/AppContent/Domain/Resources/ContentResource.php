<?php

namespace App\AppContent\Domain\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ContentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $page = [
            'id' => $this->id,
            'key' => $this->key,
            'title' => $this->title,
            'body' => $this->body,
            'is_active' => $this->is_active,
        ];
        if (auth()->guard('admin')->check()) {
            return array_merge($page, [
                'ar' => $this->translate('ar')->only('title', 'body'),
                'en' => $this->translate('en')->only('title', 'body'),
            ]);
        }

        return $page;

    }
}
