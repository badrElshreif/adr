<?php

namespace App\Admin\Domain\Models;

use App\Infrastructure\Domain\Filters\Filterable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Admin extends Authenticatable implements JWTSubject
{

    use Notifiable, HasRoles, Filterable;
    /**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = [
        'id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime'
    ];

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [
            'id'         => $this->id,
            'name'       => $this->name,
            'email'      => $this->email,
            'company_id' => $this->company_id
        ];
    }

    protected function setAvatarAttribute($value)
    {
        $image = explode('/', $value);

        if (! in_array('default-user.jpg', $image))
        {
            $this->attributes['avatar'] = end($image);
        }
        else
        {
            $this->attributes['avatar'] = null;
        }

    }

    protected function getAvatarAttribute($image)
    {

        if (isset($image) && $image != '')
        {
            return \Storage::disk('public')->url('/admins/' . $image);
        }
        else
        {
            return url('assets/images/default/default-user.jpg');
        }

    }

    public function allRoles()
    {
        return $this->morphToMany(
            'App\Admin\Domain\Models\Role',
            'model_has_roles',
            'model_id',
            'role_id'
        );
    }

    public function is($roleName = 'Normal User')
    {

        foreach ($this->roles()->get() as $role)
        {

            if ($role->name == $roleName)
            {
                return true;
            }

        }

        return false;
    }

    public function attachments()
    {
        return $this->morphMany('App\Uploader\Domain\Models\Attachment', 'creatable');
    }

    public function tokens()
    {
        return $this->morphMany('App\User\Domain\Models\DeviceToken', 'tokenable');
    }

    public function notifications()
    {
        return $this->morphMany('App\Notification\Domain\Models\Notification', 'notifiable');
    }

    public function company()
    {
        return $this->belongsTo('App\Company\Domain\Models\Company');
    }

}
