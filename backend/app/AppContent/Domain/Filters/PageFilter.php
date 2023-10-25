<?php

namespace App\AppContent\Domain\Filters;

use App\Infrastructure\Domain\Filters\QueryFilter;

class PageFilter extends QueryFilter
{
    public function isActive($status)
    {
        $this->builder->where('is_active', $status);
    }

    public function isStatic($value)
    {
        $this->builder->where('is_static', $value);
    }

    public function publicSearch($search)
    {
        $this->builder->WhereHas('translations', function ($q) use ($search) {
            $q->where('title', 'like', '%'.$search.'%')
            ->orWhere('body', 'like', '%'.$search.'%');
        });
    }
}
