<?php

namespace App\AppContent\Domain\Services\HomeContent;

use App\AppContent\Domain\Models\HomeContent;
use App\Infrastructure\Domain\Payloads\GenericPayload;
use App\Infrastructure\Domain\Services\Service;
use App\Infrastructure\Exceptions\ModelNotFoundException;
use Symfony\Component\HttpFoundation\Response;

class ToggleContentStatusService extends Service
{
    public function handle($data = [])
    {
        try {
            $page = HomeContent::findOrFail($data['content_id']);
            $page->update([
                'is_active' => ! $page->is_active,
            ]);

            return new GenericPayload($page, Response::HTTP_CREATED);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $ex) {
            throw new ModelNotFoundException;
        } catch (Exception $ex) {
            return new GenericPayload(
                __('error.someThingWrong'), 422
            );
        }
    }
}
