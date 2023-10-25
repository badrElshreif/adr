<?php

namespace App\Admin\Domain\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class AdminLiteResource extends JsonResource
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
            'id'             => $this->id,
            'name'           => $this->name,
            'phone'          => $this->phone,
            'email'          => $this->email,
            'is_active'      => (bool) $this->is_active,
            'avatar'         => $this->avatar,
            'company_id'     => $this->company_id,
            'created_at'     => Carbon::parse($this->created_at)->translatedFormat('d M Y'),
            'permissions'    => $this->getPermissionsViaRoles()->pluck('name'),
            'roles'          => RoleResource::collection($this->roles),
            'is_super_admin' => $this->hasRole('super admin') || $this->hasRole('super-admin')
        ];
    }
}
