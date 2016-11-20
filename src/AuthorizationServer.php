<?php

namespace Phisch90\OAuth\Server;

use Phisch90\OAuth\Server\Exception\AuthorizationServerException;
use Phisch90\OAuth\Server\Grant\Grant;
use Symfony\Component\HttpFoundation\JsonResponse;
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
        try {
            foreach ($this->grants as $grant) {
                if ($grant->supports($request)) {
                    return $grant->handle($request);
                }
            }
            throw new AuthorizationServerException('', null, null, 'unsupported_grant_type');
        } catch (AuthorizationServerException $exception) {
            return $this->generateErrorResponse($exception);
        }
    }

    /**
     * @param AuthorizationServerException $exception
     * @return JsonResponse
     */
    private function generateErrorResponse(AuthorizationServerException $exception)
    {
        $jsonResponseData = [
            'error' => $exception->getErrorCode(),
            'error_description' => $exception->getMessage(),
            'error_uri' => '' //TODO: implement error detail endpoint and generate uris
        ];

        return new JsonResponse($jsonResponseData, 400);
    }

    /**
     * @param Grant $grant
     */
    public function addGrant(Grant $grant)
    {
        $this->grants[] = $grant;
    }
}
