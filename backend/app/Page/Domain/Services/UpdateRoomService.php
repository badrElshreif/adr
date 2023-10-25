<?php

namespace App\Page\Domain\Services;

use App\Infrastructure\Domain\Payloads\GenericPayload;
use App\Infrastructure\Domain\Services\Service;
use App\Infrastructure\Exceptions\ModelNotFoundException;
use App\Page\Domain\Models\Page;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class UpdatePageService extends Service
{
    public function handle($data = [])
    {
        try {
            // Begin Transaction
            DB::beginTransaction();

            $page = Page::findOrFail($data['page_id']);

            $page->update($data);

            // Commit Transaction
            DB::commit();

            return new GenericPayload($page, Response::HTTP_CREATED);

        }
        catch (\Illuminate\Database\Eloquent\ModelNotFoundException $ex)
        {
            // Rollback Transaction
            DB::rollback();
            throw new ModelNotFoundException;
        }
        catch (\PDOException $ex)
        {
            // Rollback Transaction
            DB::rollback();

            return new GenericPayload(
//                $ex->getMessage()
                __('error.someThingWrong'), 422
            );
        }
        catch (Exception $ex)
        {
            // Rollback Transaction
            DB::rollback();

            return new GenericPayload(
                __('error.someThingWrong')
                , 422
            );
        }

    }

}
