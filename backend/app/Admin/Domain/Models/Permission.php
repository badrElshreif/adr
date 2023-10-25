<?php

namespace App\Admin\Domain\Models;

use App\Infrastructure\Domain\Filters\Filterable;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Permission\Models\Permission as BasePermission;

class Permission extends BasePermission
{
    use Translatable, HasFactory, Filterable;

    public $translatedAttributes = ['display_name', 'key_name'];
    protected $with = ['translations'];

    protected $fillable = ['name', 'is_active', 'guard_name'];
}
