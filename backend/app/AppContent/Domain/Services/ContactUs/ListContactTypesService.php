<?php

namespace App\AppContent\Domain\Services\ContactUs;

use App\AppContent\Domain\Models\ContactType;
use App\AppContent\Domain\Resources\ContactTypeResource;
use App\Infrastructure\Domain\Payloads\GenericPayload;
use App\Infrastructure\Domain\Services\Service;
use Symfony\Component\HttpFoundation\Response;

class ListContactTypesService extends Service
{
    public function handle($data = [])
    {
        $types = ContactType::whereIsActive(1)->get();

        return new GenericPayload(ContactTypeResource::collection($types), Response::HTTP_RESET_CONTENT);
    }
}
