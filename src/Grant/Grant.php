<?php

namespace Phisch90\OAuth\Server\Grant;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

interface Grant
{
    /**
     * @param Request $request
     * @return bool
     */
    public function supports(Request $request);

    /**
     * @param Request $request
     * @return Response
     */
    public function handle(Request $request);
}
