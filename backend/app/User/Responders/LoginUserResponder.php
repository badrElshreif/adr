<?php

namespace App\User\Responders;

use App\Infrastructure\Responders\Responder;
use App\Infrastructure\Responders\ResponderInterface;
use App\Infrastructure\Helpers\Traits\RESTApi;

class LoginUserResponder extends Responder implements ResponderInterface
{
    use RESTApi;

    public function respond()
    {
        if($this->response->getStatus() != 200 && $this->response->getStatus() != 425)
        	return $this->sendError(
        		$this->response->getData(),
        		$this->response->getStatus()
        	);

        if($this->response->getStatus() == 425)
            return $this->sendMessage([
                $this->response->getData(),[
                'is_active' => false
            ]],
            $this->response->getStatus()
        );
        return $this->sendJson(
        	$this->response->getData(),
        	$this->response->getStatus()
        );
    }
}

// $2y$10$6GEgfga5JgciipXMDjmS3eQbsP2c5F2li16ClBysGYZNpP8FD8WQW
// Moon-2512-moon@hotmail.com


// $2y$10$QiJTt37y4vB/AbpgsE35Hu7Dq/D75.RmRfrgS.1b1LWwcNfE81Rou





// admin login  $2y$10$1dd/BzAiJpA7Dt9IuqJ7/ONpoChEwZzK4Ue0YQXWRMrOOU0kDVPJW
