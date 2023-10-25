<?php

namespace App\AppContent\Domain\Services\Statistics;

use App\Company\Domain\Models\Company;
use App\Employee\Domain\Models\Employee;
use App\Infrastructure\Domain\Payloads\GenericPayload;
use App\Infrastructure\Domain\Services\Service;
use App\Room\Domain\Models\Room;
use Illuminate\Support\Arr;
use Symfony\Component\HttpFoundation\Response;

class GetStatisticsService extends Service
{
    public function handle($data)
    {
        $statistics               = [];
        $statistics['employees']  = Employee::where('is_active', 1)->count();
        $statistics['focus']      = Company::whereType('focus')->where('is_active', 1)->count();
        $statistics['companies']  = Company::whereType('companies')->where('is_active', 1)->count();
        $statistics['focus_room'] = Room::whereType('focus')->where('is_active', 1)->count();

        if (auth()->guard('company')->check())
        {
            return new GenericPayload(Arr::only($statistics, ['employees', 'focus', 'companies', 'focus_room']), Response::HTTP_RESET_CONTENT);
        }
        elseif (auth()->guard('admin')->check())
        {
            return new GenericPayload($statistics, Response::HTTP_RESET_CONTENT);
        }
        else
        {
            return new GenericPayload([], Response::HTTP_RESET_CONTENT);
        }

    }

}
