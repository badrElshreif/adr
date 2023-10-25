<?php

namespace App\Page\Domain\Services;

use App\Infrastructure\Domain\Payloads\GenericPayload;
use App\Infrastructure\Domain\Services\Service;
use App\Infrastructure\Exceptions\ModelNotFoundException;
use App\Page\Domain\Models\Page;
use Symfony\Component\HttpFoundation\Response;

class TogglePageStatusService extends Service
{
    public function handle($data = [])
    {
        try {
            $page = Page::findOrFail($data['page_id']);

            $page->update([
                'is_active' => ! $page->is_active
            ]);

            return new GenericPayload($page, Response::HTTP_CREATED);
        }
        catch (\Illuminate\Database\Eloquent\ModelNotFoundException $ex)
        {
            throw new ModelNotFoundException;
        }
        catch (Exception $ex)
        {
            return new GenericPayload(
                ['message' => __('error.someThingWrong')], 422
            );
        }

    }
}
