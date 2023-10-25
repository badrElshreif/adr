<?php

namespace App\Infrastructure\Domain\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

abstract class QueryFilter
{
    /**
     * @var Request
     */
    protected $request;

    /**
     * @var Builder
     */
    protected $builder;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function apply(Builder $builder)
    {
        $this->builder = $builder;
//dd($this->fields());
        foreach ($this->fields() as $field => $value) {
            $method = Str::camel($field);
           // dd($method);
            if (method_exists($this, $method)) {
                call_user_func_array([$this, $method], (array) $value);
            }
        }
    }

    protected function fields(): array
    {
        return array_filter(
            array_map('trim', $this->request->all())
            //  array_map(function ($value) {
            //      return is_string($value) ? trim($value, " \n\r\t\v") : $value;
            //  }, $this->request->all())
        );
    }
}
