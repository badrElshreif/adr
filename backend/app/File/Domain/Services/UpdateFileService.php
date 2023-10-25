<?php

namespace App\File\Domain\Services;

use App\File\Domain\Models\File;
use App\Infrastructure\Domain\Payloads\GenericPayload;
use App\Infrastructure\Domain\Services\Service;
use App\Infrastructure\Exceptions\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class UpdateFileService extends Service
{
    public function handle($data = [])
    {
        try {
            // Begin Transaction
            DB::beginTransaction();

            $File = File::findOrFail($data['file_id']);

            $File->update($data);

            // Commit Transaction
            DB::commit();

            return new GenericPayload($File, Response::HTTP_CREATED);

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
        catch (\Exception $ex)
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
