<?php

namespace App\AppContent\Domain\Models;

use App\Infrastructure\Domain\Filters\Filterable;
use Illuminate\Database\Eloquent\Model;

class ContactUs extends Model
{
    use Filterable;

    protected $guarded = ['id'];

    protected $dates = ['read_at'];

    public function parent()
    {
        return $this->belongsTo(self::class);
    }

    public function replies()
    {
        return $this->hasMany(ContactUs::class, 'parent_id', 'id');
    }

    public function readBy()
    {
        return $this->belongsTo('App\Admin\Domain\Models\Admin', 'read_by');
    }

    public function type()
    {
        return $this->belongsTo('App\AppContent\Domain\Models\ContactType', 'contact_type_id', 'id');
    }
}
