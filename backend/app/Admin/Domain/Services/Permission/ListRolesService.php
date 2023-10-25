<?php

namespace App\Admin\Domain\Services\Permission;

use App\Admin\Domain\Filters\RoleFilter;
use App\Admin\Domain\Models\Role;
use App\Infrastructure\Domain\Payloads\GenericPayload;
use App\Infrastructure\Domain\Services\Service;
use Symfony\Component\HttpFoundation\Response;

class ListRolesService extends Service
{
    protected $role;

    protected $filter;

    public function __construct(Role $role, RoleFilter $filter)
    {
        $this->role   = $role;
        $this->filter = $filter;
    }

    public function handle($data = [])
    {
        $company_id = null;
        $guard      = 'admin';

        if (auth()->guard('company')->check())
        {
            $data['company_id'] = auth('company')->user()->company_id;
            $data['guard_name'] = 'company';
        }

        if (auth()->guard('focus')->check())
        {
            $data['company_id'] = auth()->guard('focus')->company_id;
            $data['guard_name'] = 'focus';
        }

        $collection = $this->role->whereGuardName($guard)
            ->when($company_id, function ($collection) use ($company_id)
        {
                return $collection->where('roles.company_id', $company_id);
            });

        if (isset(request()->is_paginated) && request()->is_paginated == 0)
        {
            $roles = $collection
            // ->orderBy($order, $order_type)
                ->filter($this->filter)->get();

            return new GenericPayload($roles, Response::HTTP_OK);
        }
        else
        {
            $roles = $collection->whereNotIn('name', ['super admin', 'super-admin'])
            // ->orderBy($order, $order_type)
                ->filter($this->filter)->paginate(config('app.pagination_limit'));

            return new GenericPayload($roles, Response::HTTP_ACCEPTED);
        }

    }

}
