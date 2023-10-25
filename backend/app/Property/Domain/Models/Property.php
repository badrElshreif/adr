<?php

namespace App\Property\Domain\Models;

use App\Infrastructure\Domain\Filters\Filterable;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    use Translatable, HasFactory, Filterable;

    public $translatedAttributes = ['name'];

    protected $guarded = ['id'];

    protected $casts = [
        'is_active'   => 'boolean',
        'is_required' => 'boolean'
    ];

    public function categories()
    {
        return $this->belongsToMany('App\Category\Domain\Models\Category');
    }

    public function propertyType()
    {
        return $this->belongsTo('App\Property\Domain\Models\PropertyType');
    }

    public function propertyOptions()
    {
        return $this->hasMany('App\Property\Domain\Models\PropertyOption');
    }
}
