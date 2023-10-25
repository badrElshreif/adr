<?php

namespace App\User\Domain\Models;

use App\Infrastructure\Domain\Filters\Filterable;
use App\Location\Domain\Models\City;
use App\Order\Domain\Models\Order;
use App\User\Domain\Scopes\DeliveryScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Malhal\Geographical\Geographical;

class Delivery extends Model
{
    use HasFactory,Notifiable, Filterable, Geographical;

    protected $guard_name = 'api';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'latitude',
        'longitude',
        'address',
        'national_card_serial',
        'national_card_image',
        'license_image',
        'city_id',
        'status',
        'vehicle_model',
        'vehicle_type',
        'vehicle_plate_number',
        'bank_name',
        'iban_number',
        'bank_account',
        'stc_number',
        'wallet',
    ];

    protected $casts = [
        'status' => 'boolean',
        'is_active' => 'boolean',
    ];

    protected static $kilometers = true;
    const LATITUDE  = 'latitude';
    const LONGITUDE = 'longitude';
    protected static function booted(): void
    {
        static::addGlobalScope(new DeliveryScope);
    }

    protected function setNationalCardImageAttribute($value)
    {
        $image = explode('/', $value);
        $this->attributes['national_card_image'] = end($image);
    }

    protected function getNationalCardImageAttribute($image)
    {
        if (isset($image) && $image != '') {
            return \Storage::disk('public')->url('/delivery/'.$image);
        }

        return url('assets/images/default/default.jpg');
    }

    protected function setLicenseImageAttribute($value)
    {
        $image = explode('/', $value);
        $this->attributes['license_image'] = end($image);
    }

    protected function getLicenseImageAttribute($image)
    {
        if (isset($image) && $image != '') {
            return \Storage::disk('public')->url('/delivery/'.$image);
        }

        return url('assets/images/default/default2.jpg');
    }

    public function scopeDeliveriesByZone($query, $minRadius, $latitude, $longitude) // get Nearest Deliveries
    {
        // for nearest orders
        $haversine = "(6371 * acos(cos(radians(" . $latitude . "))
        * cos(radians(`latitude`))
        * cos(radians(`longitude`)
        - radians(" . $longitude . "))
        + sin(radians(" . $latitude . "))
        * sin(radians(`latitude`))))";

        return $query
        ->where(function ($q) use ($haversine, $minRadius) {
            $q->select('*')
            ->selectRaw("{$haversine} AS distance")
            ->whereRaw("{$haversine} < ?", [$minRadius]);
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id')->withTrashed();
    }

    public function city()
    {
        return $this->belongsTo(City::class, 'city_id');
    }

   public function orders()
   {
       return $this->hasMany(Order::class);
   }
//
//    public function orderLog()
//    {
//        return $this->hasMany(DriverToRequest::class, 'driver_id');
//    }



}
