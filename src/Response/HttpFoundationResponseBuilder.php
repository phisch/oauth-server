<?php

namespace Phisch90\OAuth\Server\Response;

use Phisch90\OAuth\Server\Exception\AuthorizationServerException;
use Symfony\Component\HttpFoundation\Response;

class HttpFoundationResponseBuilder implements ResponseBuilder 
{
    /**
     * @param AuthorizationServerException $exception
     * @return Response
     */
    public function fromException(AuthorizationServerException $exception)
    {
        $jsonResponseData = [
            'error' => $exception->getErrorCode(),
            'error_description' => $exception->getMessage(),
            'error_uri' => '' //TODO: implement error detail endpoint and generate uris
        ];

        return new Response(
            json_encode($jsonResponseData),
            400,
            [
                'Content-Type' => 'application/json'
            ]
        );
    }

}
