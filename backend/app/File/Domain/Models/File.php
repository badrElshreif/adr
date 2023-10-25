<?php

namespace App\File\Domain\Models;

use App\Infrastructure\Domain\Filters\Filterable;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use Translatable, HasFactory, Filterable;

    //use \OwenIt\Auditing\Auditable;
    public $translatedAttributes = ['name'];
    protected $with              = ['translations'];

    protected $guarded = ['id'];

    protected $casts = [
        'is_active'               => 'boolean',
        'appear_for_free_package' => 'boolean'
    ];

    // active scope
    public function scopeActive($query, $active = 1)
    {
        return $query->where('is_active', $active);
    }

    protected function setVideoAttribute($value)
    {
        $video                     = explode('/', $value);
        $this->attributes['video'] = end($video);
    }

    protected function getVideoAttribute($video)
    {

        if (isset($video))
        {
            return \Storage::disk('public')->url('/categories/' . $video);
        }
        else
        {
            return '';
        }

    }

}
