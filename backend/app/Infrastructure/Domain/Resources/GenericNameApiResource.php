<?php

namespace App\Infrastructure\Domain\Resources;

use App\Order\Domain\Models\Status;
use Illuminate\Http\Resources\Json\JsonResource;

class GenericNameApiResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $name         = '';
        $key          = '';
        if($this->key && $this->key == 'delayed') {
            $status       = Status::getAllStatusCached()->where('type','order')->where('key', 'new')->first();
            $name         = $status?->name;
            $key          = $status?->key;
        }

        $response = [
            'id'   => $this->id,
            'name' => $name  != '' ? $name :$this->name,
        ];

        if ($this->key) {
            $response['key'] = $key != '' ? $key : $this->key;
        }

        if ($this->type) {
            $response['type'] = $this->type;
        }

        if ($this->code) {
            $response['code'] = $this->code;
        }

        if (isset($this->is_active)) {
            $response['is_active'] = $this->is_active;
        }

        if ($this->value) {
            $response['value'] = $this->value;
        }

        if ($this->latitude) {
            $response['latitude'] = $this->latitude;
        }

        if ($this->longitude) {
            $response['longitude'] = $this->longitude;
        }

        return $response;
    }
}
