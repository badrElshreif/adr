<?php

namespace App\AppContent\Domain\Services\Page;

use App\AppContent\Domain\Models\Page;
use App\Infrastructure\Domain\Payloads\GenericPayload;
use App\Infrastructure\Domain\Services\Service;
use App\Infrastructure\Exceptions\ModelNotFoundException;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class CreatePageService extends Service
{
    public function handle($data = [])
    {
        try {
            $slug = Str::slug($data['en']['title']);
            if (Page::whereSlug($slug)->first()) {
                return new GenericPayload(
                    __('error.page_duplicated'), 422
                );
            }

            $data['created_by'] = 1;
            $data['slug'] = $slug;
            $data['is_static'] = 0;
            $page = Page::create($data);

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
