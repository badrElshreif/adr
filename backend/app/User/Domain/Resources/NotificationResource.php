<?php

namespace App\User\Domain\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class NotificationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $type = explode('/', $this->type);

        return array_merge([
            'id'         => $this->id,
            'data'       => $this->data,
            'is_read'    => $this->read_at ? true : false,
            //'message' => $this->data->message,
            'created_at' => \Carbon\Carbon::parse($this->created_at)->translatedFormat('d M Y')
        ]);
    }
}
