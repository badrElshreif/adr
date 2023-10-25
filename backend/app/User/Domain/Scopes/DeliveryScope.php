<?php

namespace App\User\Domain\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class DeliveryScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @return void
     */
    public function apply(Builder $builder, Model $model)
    {
        if (checkAuthAdmin()) {
            $cities_id = auth()->guard('admin')->user()->cities()->pluck('zoneable_id')->toArray();
            $builder->where(function ($q) use ($cities_id){
                $q->whereIn('deliveries.city_id', $cities_id);
            });
        }
    }
}
