<?php

namespace App\AppContent\Domain\Models;

use App\Infrastructure\Domain\Filters\Filterable;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    use HasFactory, Translatable, Filterable;

    protected $guarded = ['id'];

    public $translatedAttributes = ['question', 'answer'];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}
