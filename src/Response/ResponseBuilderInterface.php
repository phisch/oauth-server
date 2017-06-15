<?php

namespace Phisch\OAuth\Server\Response;

use Phisch\OAuth\Server\Entity\AccessTokenEntityInterface;
use Phisch\OAuth\Server\Entity\RefreshTokenEntityInterface;
use Phisch\OAuth\Server\Entity\ScopeEntityInterface;
use Phisch\OAuth\Server\Exception\AuthorizationServerException;
use Phisch\OAuth\Server\Token\TokenTypeInterface;

/**
 * TODO: check if buildSuccessResponse and buildErrorResponse can be replaced with one single buildResponse method
 * @package Phisch\OAuth\Server\Response
 */
interface ResponseBuilderInterface
{
    /**
     * @param AuthorizationServerException $exception
     * @return mixed
     */
    public function error(AuthorizationServerException $exception);

    /**
     * @param AuthorizationServerException $exception
     * @return mixed
     */
    public function errorRedirect(AuthorizationServerException $exception); // TODO: foo

    /**
     * @param TokenTypeInterface $tokenType
     * @param AccessTokenEntityInterface $accessToken
     * @param RefreshTokenEntityInterface|null $refreshToken
     * @param ScopeEntityInterface[]|null $scopes
     * @return mixed
     */
    public function success(
        TokenTypeInterface $tokenType,
        AccessTokenEntityInterface $accessToken,
        RefreshTokenEntityInterface $refreshToken = null,
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

    /**
     * @param string $redirectionUri
     * @param string $error
     * @param string $description
     * @param string $errorUri
     * @return mixed
     */
    public function buildErrorRedirectResponse($redirectionUri, $error, $description, $errorUri);
}
