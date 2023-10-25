<?php

namespace App\Users\Domain\Repositories;

use App\Infrastructure\Domain\Repositories\Repository;
use App\Users\Domain\Models\User;

class UserRepository extends Repository
{
    protected $model;

    public function __construct(User $model)
    {
        $this->model = $model;
    }
}
