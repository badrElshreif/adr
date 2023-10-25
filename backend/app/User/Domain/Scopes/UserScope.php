<?php

namespace App\User\Domain\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class UserScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @return void
     */
    public function apply(Builder $builder, Model $model)
    {
        if (checkAuthAdmin()) {
            $builder->where('type','!=','delivery')->where(function ($query) {
                $query->whereHas('addresses', function ($q) {
                    $q->whereIn('user_addresses.city_id', auth()->guard('admin')->user()->cities()->pluck('zoneable_id')->toArray());
                });
            })->orWhere('type','delivery')->whereHas('delivery', function ($q) {
                $q->whereIn('deliveries.city_id', auth()->guard('admin')->user()->cities()->pluck('zoneable_id')->toArray());
            });
        }
    }
}
