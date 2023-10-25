<?php

namespace App\AppContent\Domain\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactType extends Model
{
    use HasFactory, Translatable;

    protected $guarded = ['id'];

    public $translatedAttributes = ['name'];
}
