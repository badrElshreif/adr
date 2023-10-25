<?php

namespace App\Admin\Domain\Services\Permission;

use App\Admin\Domain\Models\Role;
use App\Infrastructure\Domain\Payloads\GenericPayload;
use App\Infrastructure\Domain\Services\Service;
use Illuminate\Support\Arr;
use Symfony\Component\HttpFoundation\Response;

class CreateRoleService extends Service
{
    public function handle($data = [])
    {
        $data['guard_name'] = 'admin';

        if (auth()->guard('company')->check())
        {
            $data['company_id'] = auth('store')->user()->company_id;
            $data['guard_name'] = 'store';
        }

        if (auth()->guard('focus')->check())
        {
            $data['company_id'] = auth()->guard('focus')->company_id;
            $data['guard_name'] = 'focus';
        }

        $role_unique_check = Role::where('guard_name', $data['guard_name'])
            ->whereHas('translations', function ($q) use ($data)
        {
                $q->whereIn('display_name', Arr::only($data, ['ar', 'en']));
            })->first();

        if ($role_unique_check)
        {
            return new GenericPayload(__('error.nameIsRepeated'), 422);
        }

        $data['name']      = $data['en']['display_name'];
        $data['is_active'] = isset($data['is_active']) ? $data['is_active'] : 1;
        $role              = Role::create($data);

        if (isset($data['permissions']))
        {
            $role->syncPermissions($data['permissions']);
            $role->givePermissionTo($data['permissions']);
        }

        return new GenericPayload($role, Response::HTTP_CREATED);

    }

}
