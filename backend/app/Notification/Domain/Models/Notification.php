<?php

namespace App\Notification\Domain\Models;

use App\Infrastructure\Domain\Filters\Filterable;
use Illuminate\Notifications\DatabaseNotification;

class Notification extends DatabaseNotification
{
    use Filterable;

    public function notifiable()
    {
        return $this->morphTo();
    }
}
