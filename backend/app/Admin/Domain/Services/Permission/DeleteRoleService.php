<?php

namespace App\Admin\Domain\Services\Permission;

use App\Admin\Domain\Models\Role;
use App\Infrastructure\Domain\Payloads\GenericPayload;
use App\Infrastructure\Domain\Services\Service;
use App\Infrastructure\Exceptions\ModelNotFoundException;
use Symfony\Component\HttpFoundation\Response;

class DeleteRoleService extends Service
{
    public function handle($data = [])
    {
        try {
            $role = Role::findOrFail($data['role_id']);
            if (count($role->users()->get()) > 0) {
                return new GenericPayload(
                    __('error.cannotDelete'), 422
                );
            }
            $role->delete();

            return new GenericPayload(['message' => __('success.deletedSuccessfuly')], Response::HTTP_NO_CONTENT);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $ex) {
            throw new ModelNotFoundException;
        } catch (\Exception $ex) {
            throw new QueryException;
        }

    }
}
