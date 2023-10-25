<?php

namespace App\File\Domain\Services;

use App\File\Domain\Models\File;
use App\Infrastructure\Domain\Payloads\GenericPayload;
use App\Infrastructure\Domain\Services\Service;
use App\Infrastructure\Exceptions\ModelNotFoundException;
use Symfony\Component\HttpFoundation\Response;

class ShowFileService extends Service
{
    public function handle($data = [])
    {
        try {
            $File = File::findOrFail($data['file_id']);

            return new GenericPayload($File, Response::HTTP_CREATED);
        }
        catch (\Illuminate\Database\Eloquent\ModelNotFoundException $ex)
        {
            throw new ModelNotFoundException;
        }
        catch (\Exception $ex)
        {
            return new GenericPayload(
                __('error.someThingWrong'), 422
            );
        }
    }
}
