<?php

namespace App\User\Domain\Models;

use App\Infrastructure\Domain\Filters\Filterable;
use App\Location\Domain\Models\Country;
use App\Order\Domain\Models\DeliveryRequest;
use App\Order\Domain\Models\Order;
use App\Order\Domain\Models\OrderStatus;
use App\RequestOfferQuantity\Domain\Models\RequestOffer;
use App\User\Domain\Scopes\UserScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Collection;
use Tymon\JWTAuth\Contracts\JWTSubject;

//use Laravel\Sanctum\HasApiTokens;

//use Laravel\Passport\HasApiTokens;

/**
 * @property Collection $requestOfferQuantities
 */
class User extends Authenticatable implements JWTSubject
//class User extends Authenticatable

{
    protected $guard_name = 'api';

    //use HasApiTokens;
    use HasFactory;

    //use HasProfilePhoto;
    use Notifiable, Filterable, SoftDeletes;

//use TwoFactorAuthenticatable;

    /**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = [
        'id'
    ];

    protected $fillable = ['name', 'email', 'phone', 'country_code', 'country_id', 'phone_verified_at', 'password', 'gender', 'avatar', 'is_active', 'login_numbers', 'last_login_at', 'verification_code', 'updated_phone', 'type', 'is_accepted', 'updated_country_code'
        //        ,'latitude','longitude'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'phone_verified_at' => 'datetime',
        'is_active'         => 'boolean'
    ];

    protected static function booted(): void
    {
        static::addGlobalScope(new UserScope);
    }

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
            'id'           => $this->id,
            'name'         => $this->name,
            'phone'        => $this->phone,
            'country_code' => $this->country_code
        ];
    }

    protected function setAvatarAttribute($value)
    {
        $image                      = explode('/', $value);
        $this->attributes['avatar'] = end($image);
    }

    protected function getAvatarAttribute($image)
    {

        if (isset($image) && $image != '')
        {
            return \Storage::disk('public')->url('/users/avatar/' . $image);
        }

        return url('assets/images/default/default.jpg');
    }

    public function attachments()
    {
        return $this->morphMany('App\Uploader\Domain\Models\Attachment', 'creatable');
    }

    public function delivery()
    {
        return $this->hasOne(Delivery::class, 'user_id');
    }

    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }

    public function deliveryOrders()
    {
        return $this->hasMany(Order::class, 'delivery_id');
    }

    public function deliveryRequests()
    {
        return $this->hasMany(DeliveryRequest::class, 'delivery_id');
    }

    public function addresses()
    {
        return $this->hasMany('App\User\Domain\Models\UserAddress')->orderBy('is_primary', 'desc');
    }

    public function ratings()
    {
        return $this->hasMany('App\Order\Domain\Models\Rating', 'user_id');
    }

    public function deliveryRatings()
    {
        return $this->hasMany('App\Order\Domain\Models\Rating', 'delivery_id');
    }

    public function statuses()
    {
        return $this->hasMany('App\User\Domain\Models\UserStatus');
    }

//    public function favourites() {

//        return $this->belongsToMany(

//                'App\Product\Domain\Models\ProductView',

//                'favourites',

//                'user_id',

//                'product_id'

//            );

//    }

//    public function admin()

//    {

//        return $this->belongsTo(Admin::class,'admin_id');

//    }
//
    public function orders()
    {
        return $this->hasMany('App\Order\Domain\Models\Order');
    }

    public function tokens()
    {
        return $this->morphMany('App\User\Domain\Models\DeviceToken', 'tokenable');
    }

    public function payments()
    {
        return $this->morphMany('App\Order\Domain\Models\Payment', 'paymentable');
    }

//    public function chats()

//    {

//        return $this->hasMany(Chat::class,'user_id')->distinct('company_id');

//    }
//
    public function orderStatuses()
    {
        return $this->morphMany('App\Order\Domain\Models\OrderStatus', 'statusable');
    }

    public function DeliveryOrderStatuses()
    {
        return $this->hasMany(OrderStatus::class, 'delivery_id');
    }

    public function notifications()
    {
        return $this->morphMany('App\Notification\Domain\Models\Notification', 'notifiable');
    }

    public function transactions()
    {
        return $this->hasMany('App\Order\Domain\Models\Transaction');
    }

//
    public function wallet()
    {
        return optional($this->transactions()->orderBy('id', 'desc')->first())->wallet_total;
    }

//
    public function cart()
    {
        return $this->hasMany('App\Order\Domain\Models\Cart');
    }

//

//    public function requestOfferQuantities(): HasMany

//    {

//        return $this->hasMany(RequestOffer::class);
//    }
}
