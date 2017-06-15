<?php

namespace Phisch\OAuth\Server\Response;

use Phisch\OAuth\Server\Entity\AccessTokenEntityInterface;
use Phisch\OAuth\Server\Entity\RefreshTokenEntityInterface;
use Phisch\OAuth\Server\Entity\ScopeEntityInterface;
use Phisch\OAuth\Server\Exception\AuthorizationServerException;
use Phisch\OAuth\Server\Token\TokenTypeInterface;

abstract class AbstractResponseBuilder implements ResponseBuilderInterface
{
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
    ) {
        $data = [
            'access_token' => $tokenType->generate($accessToken),
            'token_type' => $tokenType->getType(),
            'expires_in' => $accessToken->getExpiryDateTime()->getTimestamp() - (new \DateTime())->getTimestamp()
        ];

        // refresh token is optional
        if ($refreshToken instanceof RefreshTokenEntityInterface) {
            // TODO: check if refresh_token should use the same token type as access_token
            $data['refresh_token'] = $refreshToken->getIdentifier();
        }

        // scope is optional
        if (!empty($scopes)) {
            $data['scope'] = $this->generateScopeList($scopes);
        }


        return $this->buildSuccessResponse($data, 200);
    }

    /**
     * @param AuthorizationServerException $exception
     * @return mixed
     */
    public function error(AuthorizationServerException $exception)
    {
        $data = [
            'error' => $exception->getErrorCode(),
            'error_description' => $exception->getMessage(),
            'error_uri' => '' //TODO: implement error detail endpoint and generate uris
        ];

        return $this->buildErrorResponse($data, 400);
    }

    /**
     * @param AuthorizationServerException $exception
     */
    public function errorRedirect(AuthorizationServerException $exception)
    {
        return $this->buildErrorRedirectResponse(

            $exception->getErrorCode()

        );
    }

    /**
     * @param ScopeEntityInterface[] $scopes
     * @return string
     */
    private function generateScopeList(array $scopes)
    {
        $scopeNames = [];
        foreach ($scopes as $scope) {
            $scopeNames[] = $scope->getName();
        }
        return implode(' ', $scopeNames);
    }
}
