<?php

namespace App\Admin\Domain\Models;

use App\Infrastructure\Domain\Filters\Filterable;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Permission\Models\Role as BaseRole;

class Role extends BaseRole
{
    use Translatable, HasFactory, Filterable;

    public $translatedAttributes = ['display_name'];
    protected $with              = ['translations'];

    protected $fillable = ['name', 'is_active', 'guard_name', 'company_id'];
}
