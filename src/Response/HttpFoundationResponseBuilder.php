<?php

namespace Phisch90\OAuth\Server\Response;

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
