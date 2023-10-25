<?php

namespace App\AppContent\Domain\Services\ContactUs;

use App\AppContent\Domain\Filters\ContactUsFilter;
use App\AppContent\Domain\Models\ContactUs;
use App\Infrastructure\Domain\Payloads\GenericPayload;
use App\Infrastructure\Domain\Services\Service;
use Symfony\Component\HttpFoundation\Response;

class ListContactUsService extends Service
{
    protected $contact_us;

    protected $filter;

    public function __construct(ContactUs $contact_us, ContactUsFilter $filter)
    {
        $this->contact_us = $contact_us;
        $this->filter     = $filter;
    }

    public function handle($data = [])
    {
        $order      = isset($data['orderBy']) ? $data['orderBy'] : 'id';
        $order_type = isset($data['orderType']) ? $data['orderType'] : 'DESC';
        $limit      = isset($data['per_page']) ? $data['per_page'] : config('app.pagination_limit');

        $contact_us = $this->contact_us->whereNull('parent_id')->filter($this->filter)
            ->orderBy($order, $order_type)->paginate($limit);

        return new GenericPayload($contact_us, Response::HTTP_ACCEPTED);
    }
}
