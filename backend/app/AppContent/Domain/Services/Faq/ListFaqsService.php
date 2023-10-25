<?php

namespace App\AppContent\Domain\Services\API;

use App\AppContent\Domain\Filters\FaqFilter;
use App\AppContent\Domain\Models\Faq;
use App\Infrastructure\Domain\Payloads\GenericPayload;
use App\Infrastructure\Domain\Services\Service;

class ListFaqsService extends Service
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
        $faq = $this->faq->filter($this->filter)->paginate(config('app.pagination_limit'));

        return new GenericPayload($faq);
    }
}
