<?php

namespace App\AppContent\Domain\Filters;

use App\Infrastructure\Domain\Filters\QueryFilter;

class CurrencyFilter extends QueryFilter
{
    public function status($status)
    {
        if ($status == 'true') {
            $status = 1;
        }
        if ($status == 'false') {
            $status = 0;
        }
        $this->builder->where('is_active', $status);
    }

    public function publicSearch($search)
    {
        $this->builder->where('symbol', 'like', '%'.$search.'%')
        ->orWhereHas('translations', function ($q) use ($search) {
            $q->where('name', 'like', '%'.$search.'%');
        });
    }
}
