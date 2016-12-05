<?php

namespace Phisch90\OAuth\Server\Response;

use Phisch90\OAuth\Server\Entity\AccessTokenEntity;
use Phisch90\OAuth\Server\Entity\RefreshTokenEntity;
use Phisch90\OAuth\Server\Entity\ScopeEntity;
use Phisch90\OAuth\Server\Exception\AuthorizationServerException;
use Phisch90\OAuth\Server\Token\TokenType;

abstract class AbstractResponseBuilder implements ResponseBuilder
{
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
    ) {
        $data = [
            'access_token' => $tokenType->generate($accessToken),
            'token_type' => $tokenType->getType(),
            'expires_in' => $accessToken->getExpiryDateTime()->getTimestamp() - (new \DateTime())->getTimestamp()
        ];

        // refresh token is optional
        if ($refreshToken instanceof RefreshTokenEntity) {
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
     * @param ScopeEntity[] $scopes
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
