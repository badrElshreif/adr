<?php

namespace App\Admin\Domain\Services\Admin;

use App\Admin\Domain\Exports\AdminsExport;
use App\Admin\Domain\Filters\AdminFilter;
use App\Admin\Domain\Models\Admin;
use App\Infrastructure\Domain\Payloads\GenericPayload;
use App\Infrastructure\Domain\Services\Service;
use Excel;
use Symfony\Component\HttpFoundation\Response;

class ExportAdminsToExcelService extends Service
{
    protected $admin;

    protected $filter;

    public function __construct(Admin $admin, AdminFilter $filter)
    {
        $this->admin  = $admin;
        $this->filter = $filter;
    }

    public function handle($data = [])
    {
        $company_id = null;

        if (auth()->guard('company')->check() || auth()->guard('focus')->check())
        {
            $company_id = auth()->user()->company_id;
        }

        $this->admin = $this->admin
            ->when($company_id, function ($collection) use ($company_id)
        {
                return $collection->whereNotNull('company_id')->where('company_id', $company_id);
            }, function ($collection)
        {
                return $collection->whereNull('company_id');
            });

        return new GenericPayload(
            Excel::download(new AdminsExport($this->admin, $this->filter), 'admins.xlsx'), Response::HTTP_RESET_CONTENT
        );
    }

}
