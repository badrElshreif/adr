<?php

namespace App\Admin\Domain\Filters;

use App\Infrastructure\Domain\Filters\QueryFilter;

class PermissionFilter extends QueryFilter
{
    public function isActive($is_active)
    {
        $this->builder->where('is_active', $is_active);
    }

    public function name($name)
    {
        $this->builder->whereHas('translations', function ($q) use ($name) {
                $q->where('display_name', 'like', '%'.$name.'%');
            });
    }
}
