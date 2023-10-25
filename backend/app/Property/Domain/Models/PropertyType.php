<?php

namespace App\Property\Domain\Models;

use App\Infrastructure\Domain\Filters\Filterable;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PropertyType extends Model
{
    use Translatable, HasFactory, Filterable;

    public $translatedAttributes = ['name'];

    protected $guarded = ['id'];
    public $with = ['translations'];

    protected $casts = [
        'is_active' => 'boolean',
        'has_options' => 'boolean',
    ];
}
