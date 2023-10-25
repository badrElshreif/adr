<?php

namespace App\Admin\Domain\Resources;

use App\Location\Domain\Resources\CityResource;
use App\Location\Domain\Resources\CountryResource;
use App\Location\Domain\Resources\StateResource;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class AdminResource extends JsonResource
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
            'id'        => $this->id,
            'name'      => $this->name,
            'phone'     => $this->phone,
            'email'     => $this->email,
            'is_active' => (bool) $this->is_active,
            'avatar'    => $this->avatar,
            'image'     => optional($this->store)->image,
            'ar'        => optional($this->store)->translate('ar') ? $this->store->translate('ar')->only('name') : null,
            'en'        => optional($this->store)->translate('en') ? $this->store->translate('en')->only('name') : null,
            //            'order_limit' => optional($this->store)->order_limit,
            //            'chat_status' => optional($this->store)->chat_status,
            //            'has_chat' => optional(optional($this->store)->activePackage)->has_chat,
            'created_at' => Carbon::parse($this->created_at)->translatedFormat('d M Y'),
            //'permissions' => PermissionResource::collection($this->getAllPermissions()),
            'permissions'    => $this->getPermissionsViaRoles()->pluck('name'),
            'roles'          => RoleResource::collection($this->roles),
            'countries'      => auth()->guard('admin')->check() ? $this->countries : [],
            'states'         => auth()->guard('admin')->check() ? $this->states : [],
            'cities'         => auth()->guard('admin')->check() ? $this->cities : [],
            'is_super_admin' => $this->hasRole('super admin') || $this->hasRole('super-admin'),
            'category_id'    => optional($this->store)->category_id,
        ];
    }
}
