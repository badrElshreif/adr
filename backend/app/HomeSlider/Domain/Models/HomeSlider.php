<?php

namespace App\HomeSlider\Domain\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomeSlider extends Model
{
    use HasFactory;

    protected $fillable = ['image', 'is_active'];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function scopeActive($query, $is_active)
    {
        if ($is_active == 1) {
            return $query->where('is_active', 1);
        } else {
            return $query->where('is_active', 0);
        }
    }

    protected function setImageAttribute($value)
    {
        $image = explode('/', $value);
        $this->attributes['image'] = end($image);
    }

    protected function getImageAttribute($image)
    {
        if (isset($image) && $image != '') {
            return \Storage::disk('public')->url('/homeSlider/'.$image);
        }

        return url('assets/images/default/default.jpg');
    }
}
