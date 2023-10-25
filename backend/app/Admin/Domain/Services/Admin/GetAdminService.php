<?php

namespace App\Admin\Domain\Services\Admin;

use App\Admin\Domain\Models\Admin;
use App\Company\Domain\Models\CompanyAdmin;
use App\Company\Domain\Models\FocusAdmin;
use App\Infrastructure\Domain\Payloads\GenericPayload;
use App\Infrastructure\Domain\Services\Service;
use App\Infrastructure\Exceptions\UserNotFoundException;
use Symfony\Component\HttpFoundation\Response;

class GetAdminService extends Service
{
    public function handle($data = [])
    {
        try {

            if (auth()->guard('company')->check() || auth()->guard('focus')->check())
            {

                if (auth()->user()->store->type == 'companies')
                {
                    $admin = CompanyAdmin::with(['roles.permissions.translations', 'company.translations'])->findOrFail($data['admin_id']);
                }
                else
                {
                    $admin = FocusAdmin::with(['roles.permissions.translations', 'company.translations'])->findOrFail($data['admin_id']);
                }

            }
            else
            {
                $relations = [
                    'roles.permissions.translations',
                    'company.translations'
                ];
                $admin = Admin::with($relations)->findOrFail($data['admin_id']);
            }

            return new GenericPayload($admin, Response::HTTP_CREATED);

        }
        catch (\Illuminate\Database\Eloquent\ModelNotFoundException $ex)
        {
            throw new UserNotFoundException;
        }
        catch (Exception $ex)
        {
            return new GenericPayload(
                ('error.someThingWrong'), 422
            );
        }

    }

}
