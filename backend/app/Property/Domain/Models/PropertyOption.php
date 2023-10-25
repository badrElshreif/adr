<?php

namespace App\Property\Domain\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PropertyOption extends Model
{
    use Translatable, HasFactory;

    protected $guarded = ['id'];

    public $translatedAttributes = ['name'];

    public function property()
    {
        return $this->belongsTo('App\Property\Domain\Models\Property');
    }
}
