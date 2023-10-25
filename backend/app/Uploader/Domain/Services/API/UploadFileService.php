<?php

namespace App\Uploader\Domain\Services\API;

use App\Infrastructure\Domain\Payloads\GenericPayload;
use App\Infrastructure\Domain\Services\Service;
use App\Infrastructure\Helpers\Traits\UploaderHelper;

class UploadFileService extends Service
{
    use UploaderHelper;

    public function handle($data = [])
    {
        $width  = isset($data['width']) ? $data['width'] : null;
        $height = isset($data['height']) ? $data['height'] : null;
        $file   = $this->uploadImage($data['file'], $data['path'], $width, $height);

        return new GenericPayload($file);
    }
}
