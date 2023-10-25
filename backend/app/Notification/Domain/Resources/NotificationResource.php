<?php

namespace App\Notification\Domain\Resources;

use App\Order\Domain\Models\Order;
use App\User\Domain\Resources\UserLiteResource;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Arr;

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
        //$order_type = explode("\\", $this->type);
        $user_type = explode('\\', $this->notifiable_type);
        $content   = $this->data;
        $data      = $this->data;

        if (! isset($data['company_id']))
        {
            $data['company_id'] = isset($data['model_id']) ? Order::where('id', $data['model_id'])->first()?->company_id : null;
        }

        $locale = app()->getLocale();
        $title  = isset($content["{$locale}"]) ? $content["{$locale}"]['title'] : null;
        $body   = isset($content["{$locale}"]) ? $content["{$locale}"]['body'] : null;

        return [
            'id'         => $this->id,
            'target'     => end($user_type),
            'data'       => array_merge(Arr::except($data, ['title', 'body']), [
                'title' => $title,
                'body'  => $body
            ]),
            'user'       => new UserLiteResource($this->notifiable),
            'is_read'    => $this->read_at ? true : false,

//'data' => Arr::except($this->data, ['title', 'body']),
            //'notif_type' => end($order_type),
            'created_at' => \Carbon\Carbon::parse($this->created_at)->translatedFormat('d M Y')
        ];
    }

}
