<?php

namespace App\AppContent\Domain\Services\HomeContent;

use App\AppContent\Domain\Filters\PageFilter;
use App\AppContent\Domain\Models\HomeContent;
use App\Infrastructure\Domain\Payloads\GenericPayload;
use App\Infrastructure\Domain\Services\Service;
use Symfony\Component\HttpFoundation\Response;

class ListContentService extends Service
{
    protected $filter;

    public function __construct(PageFilter $filter)
    {
        $this->filter = $filter;
    }

    public function handle($data = [])
    {
        $limit = isset($data['per_page']) ? $data['per_page'] : config('app.pagination_limit');
        $pages = HomeContent::when(! auth('admin')->check(), function ($q) {
            $q->whereIsActive(1);
        })->filter($this->filter);
        if (! isset($data['is_paginated']) || $data['is_paginated'] == 0) {
            $pages = $pages->get();

            return new GenericPayload($pages, Response::HTTP_OK);
        } else {
            $pages = $pages->paginate($limit);

            return new GenericPayload($pages, Response::HTTP_ACCEPTED);
        }

    }
}
