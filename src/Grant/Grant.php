<?php

namespace Phisch\OAuth\Server\Grant;

use Phisch\OAuth\Server\Response\ResponseBuilder;
use Symfony\Component\HttpFoundation\Request;

interface Grant
{
    /**
     * @param Request $request
     * @return bool
     */
    public function supports(Request $request);

    /**
     * @param Request $request
     * @param ResponseBuilder $responseBuilder
     * @return mixed
     */
    public function handle(Request $request, ResponseBuilder $responseBuilder);
}
