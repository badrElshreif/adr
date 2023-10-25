<?php

namespace App\AppContent\Domain\Services\API;

use App\AppContent\Domain\Models\Faq;
use App\Infrastructure\Domain\Payloads\GenericPayload;
use App\Infrastructure\Domain\Services\Service;

class CreateFaqService extends Service
{
    public function handle($data = [])
    {
        try {
            $faq = Faq::create($data);
        } catch (Exception $ex) {
            return new GenericPayload(
                ['message' => __('error.someThingWrong')], 422
            );
        }

        return new GenericPayload($faq);

    }
}
