<?php

namespace Phisch\OAuth\Server\Response;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

class HttpFoundationResponseBuilder extends AbstractResponseBuilder
{
    /**
     * @param array $data
     * @param int $status
     * @return Response
     */
    public function buildErrorResponse(array $data, $status)
    {
        return new Response(
            json_encode($data),
            $status,
            [
                'Content-Type' => 'application/json'
            ]
        );
    }

    /**
     * @param $redirectionUri
     * @param $error
     * @param $description
     * @param $errorUri
     * @return RedirectResponse
     */
    public function buildErrorRedirectResponse($redirectionUri, $error, $description, $errorUri)
    {
        return new RedirectResponse('/', 302);
    }

    /**
     * @param array $data
     * @param int $status
     * @return Response
     */
    public function buildSuccessResponse(array $data, $status)
    {
        return new Response(
            json_encode($data),
            $status,
            [
                'Content-Type' => 'application/json'
            ]
        );
    }
}
