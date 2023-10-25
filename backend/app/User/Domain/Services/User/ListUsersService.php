<?php

namespace App\User\Domain\Services\User;

use App\Employee\Domain\Models\Employee;
use App\Infrastructure\Domain\Payloads\GenericPayload;
use App\Infrastructure\Domain\Services\Service;
use App\User\Domain\Filters\UserFilter;
use Symfony\Component\HttpFoundation\Response;

class ListUsersService extends Service
{
    protected $user;

    protected $filter;

    public function __construct(Employee $user, UserFilter $filter)
    {
        $this->user   = $user;
        $this->filter = $filter;
    }

    public function handle($data = [])
    {
        $order      = request()->get('orderBy', 'id');
        $order_type = request()->get('orderType', 'DESC');
        $isTrashed  = request()->get('isTrashed', 0);

        $users =
        $this->user
            ->filter($this->filter);

        if (auth()->guard('admin')->check())
        {

            if ($isTrashed == 1)
            {
                $users = $users->onlyTrashed();
            }

        }
        else
        {
            $users = $this->user;
        }

        if (isset(request()->is_paginated) && (request()->is_paginated == 'false' || request()->is_paginated == 0))
        {
            $users = $users->get();

            return new GenericPayload($users, Response::HTTP_OK);
        }
        else
        {
            $users = $users->orderBy($order, $order_type)->paginate(config('app.pagination_limit'));

            return new GenericPayload($users, Response::HTTP_ACCEPTED);
        }

    }

}
