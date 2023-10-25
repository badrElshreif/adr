<?php

namespace App\Notification\Domain\Scopes;

use App\User\Domain\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class NotificationScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @return void
     */
    public function apply(Builder $builder, Model $model)
    {
        if (checkAuthAdmin()) {
            // get all users id After UserScope
            $users = User::pluck('id')->toArray();
            $builder->whereIn('notifications.notifiable_id', $users)->where('notifiable_type', get_class(new User()));
        }
    }
}
