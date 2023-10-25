<?php

namespace App\Infrastructure\Exceptions;

use Exception;

class ChatNotFoundException extends Exception
{
    use ExceptionTrait;

    public function render()
    {
        return $this->renderException('ChatNotFoundException', __('error.no_chat_yet'), 422);
    }
}
