<?php

namespace Phisch90\OAuth\Server;

use Phisch90\OAuth\Server\Exception\AuthorizationServerException;
use Phisch90\OAuth\Server\Grant\Grant;
use Phisch90\OAuth\Server\Response\ResponseBuilder;
use Symfony\Component\HttpFoundation\Request;

class AuthorizationServer
{
    /**
     * @var Grant[]
     */
    private $grants = [];

    /**
     * @var ResponseBuilder
     */
    private $responseBuilder;

    /**
     * AuthorizationServer constructor.
     * @param Grant[] $grants
     * @param ResponseBuilder $responseBuilder
     */
    public function __construct(array $grants, ResponseBuilder $responseBuilder)
    {
        $this->grants = $grants;
        $this->responseBuilder = $responseBuilder;
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function tokenEndpoint(Request $request)
    {
        try {
            foreach ($this->grants as $grant) {
                if ($grant->supports($request)) {
                    return $grant->handle($request, $this->responseBuilder);
                }
            }
            throw new AuthorizationServerException(
                'The requested grant_type is unsupported.',
                null,
                null,
                'unsupported_grant_type'
            );
        } catch (AuthorizationServerException $exception) {
            return $this->responseBuilder->error($exception);
        }
    }

    public function authorizationEndpoint(Request $request)
    {
    }
}
