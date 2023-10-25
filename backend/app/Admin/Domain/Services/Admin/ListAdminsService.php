<?php

namespace App\Admin\Domain\Services\Admin;

use App\Admin\Domain\Filters\AdminFilter;
use App\Admin\Domain\Models\Admin;
use App\Company\Domain\Models\CenterAdmin;
use App\Company\Domain\Models\CompanyAdmin;
use App\Infrastructure\Domain\Payloads\GenericPayload;
use App\Infrastructure\Domain\Services\Service;
use Symfony\Component\HttpFoundation\Response;

class ListAdminsService extends Service
{
    protected $admin;

    protected $filter;

    public function __construct(AdminFilter $filter)
    {
        $this->filter = $filter;
    }

    public function handle($data = [])
    {

//$company_id = null;
        // if(auth()->guard('company')->check() || auth()->guard('focus')->check()){
        $company_id = auth()->user()->company_id;

        if (auth()->guard('company')->check())
        {
            $admin = CompanyAdmin::where('company_id', $company_id);
        }
        elseif (auth()->guard('focus')->check())
        {
            $admin = CenterAdmin::where('company_id', $company_id);
        }
        else
        {
            $admin = Admin::whereNull('company_id');
        }

        $order      = $data['orderBy'] ?: 'id';
        $order_type = $data['orderType'] ?: 'ASC';
        $admins     = $admin->where('id', '!=', auth()->id())
            ->with('roles.permissions.translations', 'roles.translations')
            ->when(isset($data['country_id']) && $data['country_id'] != null, function ($collection) use ($data)
        {
                return $collection->whereHas('countries', function ($q) use ($data)
            {
                    $q->where('zoneables.zoneable_id', $data['country_id']);
                });
            })
            ->when(isset($data['state_id']) && $data['state_id'] != null, function ($collection) use ($data)
        {
                return $collection->whereHas('states', function ($q) use ($data)
            {
                    $q->where('zoneables.zoneable_id', $data['state_id']);
                });
            })
            ->when(isset($data['city_id']) && $data['city_id'] != null, function ($collection) use ($data)
        {
                return $collection->whereHas('cities', function ($q) use ($data)
            {
                    $q->where('zoneables.zoneable_id', $data['city_id']);
                });
            })
            ->filter($this->filter)
            ->orderBy($order, $order_type)->paginate(config('app.pagination_limit'));
        return new GenericPayload($admins, Response::HTTP_ACCEPTED);
    }

}
