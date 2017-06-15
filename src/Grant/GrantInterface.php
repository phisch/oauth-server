<?php

namespace Phisch\OAuth\Server\Grant;

use Phisch\OAuth\Server\Response\ResponseBuilderInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

interface GrantInterface
{
    /**
     * @param Request $request
     * @return bool
     */
    public function supports(Request $request);

    /**
     * @param Request $request
     * @param ResponseBuilderInterface $responseBuilder
     * @return Response
     */
    public function handle(Request $request, ResponseBuilderInterface $responseBuilder);

    /**
     * @param Request $request
     * @return Response
     */
    public function validate(Request $request);
}
