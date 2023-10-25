<?php

namespace App\Page\Domain\Services;

use App\Infrastructure\Domain\Payloads\GenericPayload;
use App\Infrastructure\Domain\Services\Service;
use App\Infrastructure\Exceptions\ModelNotFoundException;
use App\Page\Domain\Models\Page;
use Symfony\Component\HttpFoundation\Response;

class DeletePageService extends Service
{
    public function handle($data = [])
    {
        try {
            $page = Page::findOrFail($data['page_id']);

            $page->delete();

            return new GenericPayload(['message' => __('success.deletedSuccessfuly')], Response::HTTP_NO_CONTENT);

        }
        catch (\Illuminate\Database\Eloquent\ModelNotFoundException $ex)
        {
            throw new ModelNotFoundException;
        }
        catch (Exception $ex)
        {
            return new GenericPayload(
                __('error.someThingWrong'), 422
            );
        }

    }

}
