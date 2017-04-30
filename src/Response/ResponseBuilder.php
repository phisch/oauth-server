<?php

namespace Phisch\OAuth\Server\Response;

use Phisch\OAuth\Server\Entity\AccessTokenEntity;
use Phisch\OAuth\Server\Entity\RefreshTokenEntity;
use Phisch\OAuth\Server\Entity\ScopeEntity;
use Phisch\OAuth\Server\Exception\AuthorizationServerException;
use Phisch\OAuth\Server\Token\TokenType;

/**
 * TODO: check if buildSuccessResponse and buildErrorResponse can be replaced with one single buildResponse method
 * @package Phisch\OAuth\Server\Response
 */
interface ResponseBuilder
{
    /**
     * @param AuthorizationServerException $exception
     * @return mixed
     */
    public function error(AuthorizationServerException $exception);

    /**
     * @param TokenType $tokenType
     * @param AccessTokenEntity $accessToken
     * @param RefreshTokenEntity|null $refreshToken
     * @param ScopeEntity[]|null $scopes
     * @return mixed
     */
    public function success(
        TokenType $tokenType,
        AccessTokenEntity $accessToken,
        RefreshTokenEntity $refreshToken = null,
        array $scopes = null
    );

    /**
     * @param array $data
     * @param int $status
     * @return mixed
     */
    public function buildSuccessResponse(array $data, $status);

    /**
     * @param array $data
     * @param int $status
     * @return mixed
     */
    public function buildErrorResponse(array $data, $status);
}
