<?php

namespace App\AppContent\Domain\Services\Page;

use App\AppContent\Domain\Models\Page;
use App\Infrastructure\Domain\Payloads\GenericPayload;
use App\Infrastructure\Domain\Services\Service;
use App\Infrastructure\Exceptions\ModelNotFoundException;
use Symfony\Component\HttpFoundation\Response;

class DeletePageService extends Service
{
    public function handle($data = [])
    {
        try {
            $page = Page::whereSlug($data['slug'])->where('is_static', 0)->firstOrFail();
            $page->delete();

            return new GenericPayload(['message' => __('success.deletedSuccessfuly')], Response::HTTP_NO_CONTENT);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $ex) {
            throw new ModelNotFoundException;
        } catch (Exception $ex) {
            return new GenericPayload(
                __('error.someThingWrong'), 422
            );
        }

    }
}
