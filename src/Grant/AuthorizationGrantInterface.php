<?php

namespace Phisch\OAuth\Server\Grant;

use Phisch\OAuth\Server\Response\ResponseBuilder;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

interface AuthorizationGrantInterface extends GrantInterface
{
    /**
     * @return Response
     */
    public function cancel();
}
