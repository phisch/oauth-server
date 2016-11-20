<?php

namespace Phisch90\OAuth\Server;

use Phisch90\OAuth\Server\Grant\Grant;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthorizationServer
{
    /**
     * @var Grant[]
     */
    private $grants = [];

    /**
     * @param Request $request
     * @return Response
     */
    public function tokenEndpoint(Request $request)
    {
        foreach ($this->grants as $grant) {
            if ($grant->supports($request)) {
                return $grant->handle($request);
            }
        }
    }

    /**
     * @param Grant $grant
     */
    public function addGrant(Grant $grant)
    {
        $this->grants[] = $grant;
    }
}
