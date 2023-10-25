<?php

namespace App\Admin\Domain\Services\Admin;

use App\Admin\Domain\Models\Admin;
use App\Company\Domain\Models\CenterAdmin;
use App\Company\Domain\Models\CompanyAdmin;
use App\Infrastructure\Domain\Payloads\GenericPayload;
use App\Infrastructure\Domain\Services\Service;
use App\Infrastructure\Exceptions\UserNotFoundException;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class UpdateAdminService extends Service
{
    public function handle($data = [])
    {
        try {

            if (isset($data['admin_id']))
            {
                $admin = Admin::findOrFail($data['admin_id']);
            }
            else
            {
                $admin = auth()->user();
            }

            if (isset($data['password']))
            {
                $data['password'] = Hash::make($data['password']);
            }

            $updated_data = Arr::except($data, ['roles', 'admin_id', 'image']);

            if (auth()->guard('company')->check())
            {
                $admin = CompanyAdmin::findOrFail($admin->id);

            }
            elseif (auth()->guard('focus')->check())
            {
                $admin = CenterAdmin::findOrFail($admin->id);

            }
            else
            {
                $admin = Admin::findOrFail($admin->id);
            }

            $admin->update($updated_data);

            if (isset($data['country_id']))
            {
                // assign this admin to countries
                $admin->countries()->sync($data['country_id']);
            }

            if (isset($data['state_id']))
            {
                // assign this admin to states
                $admin->states()->sync($data['state_id']);
            }

            if (isset($data['city_id']))
            {
                // assign this admin to cities
                $admin->cities()->sync($data['city_id']);
            }

            if (isset($data['roles']) && ! ($admin->hasRole('super admin') || $admin->hasRole('super-admin')))
            {
                $admin->syncRoles($data['roles']);
            }

        }
        catch (\Illuminate\Database\Eloquent\ModelNotFoundException $ex)
        {
            throw new UserNotFoundException;
        }
        catch (\Spatie\Permission\Exceptions\RoleDoesNotExist $ex)
        {
            return new GenericPayload(
                __('error.invalidRole'), 422
            );
        }
        catch (Exception $ex)
        {
            return new GenericPayload(
                __('error.someThingWrong'), 422
            );
        }

        return new GenericPayload($admin, Response::HTTP_CREATED);
    }

}
