<?php

namespace App\File\Domain\Filters;

use App\Infrastructure\Domain\Filters\QueryFilter;
use Illuminate\Database\Eloquent\Builder;

class FileFilter extends QueryFilter
{

    public function name($name)
    {
        $this->builder->whereHas('translations', function ($q) use ($name)
        {
            $q->where('name', 'like', '%' . $name . '%');
        });
    }

    public function type($type)
    {
        $this->builder->where('type', $type);
    }

    public function status($status)
    {
        $this->builder->where('is_active', $status);
    }

    public function publicSearch($search)
    {
        $this->builder->where(function ($query) use ($search)
        {
            $query->whereHas('translations', function ($q) use ($search)
            {
                $q->where('name', 'like', '%' . $search . '%');
            });
        });
    }

}
