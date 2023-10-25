<?php

namespace App\Admin\Domain\Services\Admin;

use App\Admin\Domain\Models\Admin;
use App\Company\Domain\Models\CenterAdmin;
use App\Company\Domain\Models\CompanyAdmin;
use App\Infrastructure\Domain\Payloads\GenericPayload;
use App\Infrastructure\Domain\Services\Service;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class CreateAdminService extends Service
{
    public function handle($data = [])
    {
        $data['password']  = Hash::make($data['password']);
        $data['is_active'] = isset($data['is_active']) ? $data['is_active'] : 1;

        if (auth()->guard('company')->check() || auth()->guard('focus')->check())
        {
            $data['company_id'] = auth()->user()->company_id;
            DB::beginTransaction();

            if (auth()->user()->store->type == 'companies')
            {
                $admin = CompanyAdmin::create($data);
            }
            else
            {
                $admin = CenterAdmin::create($data);
            }

//            $admin->user()->create($data);
        }
        else
        {
            $admin = Admin::create($data);
        }

        if (isset($data['country_id']))
        {
            // assign this admin to countries
            $admin->countries()->attach($data['country_id']);
        }

        if (isset($data['state_id']))
        {
            // assign this admin to states
            $admin->states()->attach($data['state_id']);
        }

        if (isset($data['city_id']))
        {
            // assign this admin to cities
            $admin->cities()->attach($data['city_id']);
        }

        if (isset($data['roles']))
        {
            $admin->syncRoles($data['roles']);
        }

        DB::commit();

        return new GenericPayload($admin, Response::HTTP_CREATED);
    }

}
