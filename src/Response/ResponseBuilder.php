<?php

namespace Phisch90\OAuth\Server\Response;

use Phisch90\OAuth\Server\Exception\AuthorizationServerException;

interface ResponseBuilder
{
    /**
     * @param AuthorizationServerException $exception
     * @return mixed
     */
    public function fromException(AuthorizationServerException $exception);
}
