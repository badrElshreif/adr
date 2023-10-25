<?php

namespace App\File\Domain\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BackgroundTranslation extends Model
{
    use HasFactory;

    protected $table = 'background_translations';

    public $timestamps = false;

    protected $guarded = ['id'];

    protected function getTagsAttribute($value)
    {

        if (isset($value))
        {
            return (array) json_decode($value);
        }
        else
        {
            return [];
        }

    }

}
