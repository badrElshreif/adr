<?php

namespace App\AppContent\Domain\Services\API;

use App\AppContent\Domain\Exports\FaqExport;
use App\AppContent\Domain\Filters\FaqFilter;
use App\AppContent\Domain\Models\Faq;
use App\Infrastructure\Domain\Payloads\GenericPayload;
use App\Infrastructure\Domain\Services\Service;
use Excel;

class ExportFaqsToExcelService extends Service
{
    protected $faq;

    protected $filter;

    public function __construct(Faq $faq, FaqFilter $filter)
    {
        $this->faq = $faq;
        $this->filter = $filter;
    }

    public function handle($data = [])
    {
        return new GenericPayload(
            Excel::download(new FaqExport($this->faq, $this->filter), 'faqs.xlsx')
        );
    }
}
