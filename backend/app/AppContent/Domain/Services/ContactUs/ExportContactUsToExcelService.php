<?php

namespace App\AppContent\Domain\Services\ContactUs;

use App\AppContent\Domain\Exports\ContactUsExport;
use App\AppContent\Domain\Filters\ContactUsFilter;
use App\AppContent\Domain\Models\ContactUs;
use App\Infrastructure\Domain\Payloads\GenericPayload;
use App\Infrastructure\Domain\Services\Service;
use Excel;
use Symfony\Component\HttpFoundation\Response;

class ExportContactUsToExcelService extends Service
{
    protected $contact_us;

    protected $filter;

    public function __construct(ContactUs $contact_us, ContactUsFilter $filter)
    {
        $this->contact_us = $contact_us;
        $this->filter = $filter;
    }

    public function handle($data = [])
    {
        return new GenericPayload(
            Excel::download(new ContactUsExport($this->contact_us->whereNull('parent_id'), $this->filter), 'contact_us.xlsx'), Response::HTTP_RESET_CONTENT
        );
    }
}
