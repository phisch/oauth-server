<?php

namespace Phisch\OAuth\Server;

use Phisch\OAuth\Server\Exception\AuthorizationServerException;
use Phisch\OAuth\Server\Grant\GrantInterface;
use Phisch\OAuth\Server\Response\ResponseBuilderInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class Server
{
    /**
     * @var GrantInterface[]
     */
    private $grants = [];

    /**
     * @var ResponseBuilderInterface
     */
    private $responseBuilder;

    /**
     * AuthorizationServer constructor.
     * @param GrantInterface[] $grants
     * @param ResponseBuilderInterface $responseBuilder
     */
    public function __construct(array $grants, ResponseBuilderInterface $responseBuilder)
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


    /**
     * @param Request $request
     * @return Response|null
     */
    public function validateAuthorization(Request $request)
    {
        try {
            $this->getGrant($request)->validate($request);
        } catch (AuthorizationServerException $exception) {
            return $this->responseBuilder->error($exception);
        }
    }

    public function handleAuthorization(Request $request)
    {
        try {
            return $this->getGrant($request)->handle($request, $this->responseBuilder);
        } catch (AuthorizationServerException $exception) {
            return $this->responseBuilder->error($exception);
        }
    }

    public function cancelAuthorization(Request $request)
    {
        //return $this->getGrant($request)->cancel($request, $this->responseBuilder);
    }

    /**
     * @param $request
     * @return mixed|GrantInterface
     */
    private function getGrant($request)
    {
        foreach ($this->grants as $grant) {
            if ($grant->supports($request)) {
                return $grant;
            }
        }
        // TODO: throw invalid grant exception
    }
}
