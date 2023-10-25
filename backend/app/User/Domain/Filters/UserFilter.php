<?php

namespace App\User\Domain\Filters;

use App\Infrastructure\Domain\Filters\QueryFilter;
use Illuminate\Database\Eloquent\Builder;

class UserFilter extends QueryFilter
{
    public function isActive($is_active)
    {
        $this->builder->where('is_active', $is_active);
    }

    public function email($email)
    {
        $this->builder->where('email', $email);
    }

// public function status($status)

// {

//     if ($status == 'new') {

//         $statuses = [0];

//     } elseif ($status == 'current') {

//         $statuses = [1];

//     } elseif ($status == 'accepted') {

//         $statuses = [1];

//     } elseif ($status == 'rejected') {

//         $statuses = [2];

//     } else {

//         $statuses = [$status];

//     }

//     $this->builder->whereIn('is_accepted', $statuses);
    // }

    public function deliveryStatus($status)
    {

        if ($status == 'on')
        {
            $statuses = [1];
        }
        elseif ($status == 'off')
        {
            $statuses = [0];
        }
        else
        {
            $statuses = [$status];
        }

        $this->builder->whereHas('delivery', function ($q) use ($statuses)
        {
            $q->whereIn('is_accepted', $statuses);
        });
    }

    public function type($type)
    {
        $this->builder->where('type', $type);
    }

    public function phone($phone)
    {

        if (str_starts_with($phone, '0'))
        {
            $phone2 = substr($phone, 1, 20);
        }

        $this->builder->whereIn('phone', [$phone, $phone2]);
    }

    public function gender($gender)
    {
        $this->builder->where('gender', $gender);
    }

    public function name($name)
    {
        $this->builder->where('name', $name);
    }

    public function publicSearch($search)
    {
        $phone2 = null;

        if (str_starts_with($search, '0'))
        {
            $phone2 = substr($search, 1, 20);
        }

        $this->builder->where(function ($q) use ($phone2, $search)
        {
            $q->where('name', 'like', '%' . $search . '%')->orWhere('email', 'like', '%' . $search . '%')->orWhere('phone', $search)->orWhere('country_code', $search)
                ->when($phone2, function ($collection) use ($phone2)
            {
                    return $collection->orWhere('phone', $phone2);
                })
                ->orWhereHas('addresses', function ($q) use ($search)
            {
                    $q->where('address', 'like', '%' . $search . '%')
                        ->orWhereHas('state', function ($q) use ($search)
                {
                            $q->whereRelation('translations', 'name', 'like', '%' . $search . '%');
                        })
                        ->orWhereHas('city', function ($q) use ($search)
                {
                            $q->whereRelation('translations', 'name', 'like', '%' . $search . '%');
                        })
                        ->orWhereHas('country', function ($q) use ($search)
                {
                            $q->whereRelation('translations', 'name', 'like', '%' . $search . '%');
                        });
                })->orWhereHas('delivery', function ($q) use ($search)
            {
                $q->whereHas('city', function ($q) use ($search)
                {
                    $q->whereRelation('translations', 'name', 'like', '%' . $search . '%');
                });
            });
        });
    }

    public function address($address)
    {
        $this->builder->whereHas('addresses', function (Builder $query)
        {
            $query->where('address', 'like', '%' . $address . '%');
        });
    }

    public function city($city)
    {
        $this->builder->whereHas('addresses', function (Builder $query) use ($city)
        {
            $query->where('city_id', $city);
        });
    }

    public function state($state)
    {
        $this->builder->whereHas('addresses', function (Builder $query) use ($state)
        {
            $query->where('state_id', $state);
        });
    }

    public function country($country)
    {
        $this->builder->whereHas('addresses', function (Builder $query) use ($country)
        {
            $query->where('country_id', $country);
        });
    }

    public function orderBy($orderBy)
    {
        $this->builder->orderBy($orderBy, request()->orderType ?? 'DESC');
    }

}
