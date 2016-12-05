<?php

namespace Phisch90\OAuth\Server\Grant;

use Phisch90\OAuth\Server\Entity\ClientEntity;
use Phisch90\OAuth\Server\Entity\ScopeEntity;
use Phisch90\OAuth\Server\Entity\UserEntity;
use Phisch90\OAuth\Server\Exception\AuthorizationServerException;
use Phisch90\OAuth\Server\Repository\AccessTokenRepository;
use Phisch90\OAuth\Server\Repository\ClientRepository;
use Phisch90\OAuth\Server\Repository\RefreshTokenRepository;
use Phisch90\OAuth\Server\Repository\ScopeRepository;
use Phisch90\OAuth\Server\Repository\UserRepository;
use Phisch90\OAuth\Server\Response\ResponseBuilder;
use Phisch90\OAuth\Server\Token\TokenType;
use Symfony\Component\HttpFoundation\Request;

class PasswordCredentialsGrant implements Grant
{

    /**
     * @var ClientRepository
     */
    private $clientRepository;

    /**
     * @var ScopeRepository
     */
    private $scopeRepository;

    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * @var AccessTokenRepository
     */
    private $accessTokenRepository;

    /**
     * @var RefreshTokenRepository
     */
    private $refreshTokenRepository;

    /**
     * @var TokenType
     */
    private $token;

    /**
     * @param ClientRepository $clientRepository
     * @param ScopeRepository $scopeRepository
     * @param UserRepository $userRepository
     * @param AccessTokenRepository $accessTokenRepository
     * @param RefreshTokenRepository $refreshTokenRepository
     * @param TokenType $token
     */
    public function __construct(
        ClientRepository $clientRepository,
        ScopeRepository $scopeRepository,
        UserRepository $userRepository,
        AccessTokenRepository $accessTokenRepository,
        RefreshTokenRepository $refreshTokenRepository,
        TokenType $token
    ) {
        $this->clientRepository = $clientRepository;
        $this->scopeRepository = $scopeRepository;
        $this->userRepository = $userRepository;
        $this->accessTokenRepository = $accessTokenRepository;
        $this->refreshTokenRepository = $refreshTokenRepository;
        $this->token = $token;
    }

    /**
     * @param Request $request
     * @return bool
     */
    public function supports(Request $request)
    {
        return $request->get('grant_type') === $this->getIdentifier();
    }

    /**
     * @param Request $request
     * @param ResponseBuilder $responseBuilder
     * @return mixed
     */
    public function handle(Request $request, ResponseBuilder $responseBuilder)
    {
        $client = $this->validateClient($request);
        $scopes = $this->validateScopes($request);
        $user = $this->validateUser($request);

        // check if scopes fit for client

        $expiryDateTime = (new \DateTime())->add(new \DateInterval('PT1H'));
        $accessToken = $this->accessTokenRepository->createToken($client, $user, $scopes, $expiryDateTime);

        $expiryDateTime = (new \DateTime())->add(new \DateInterval('P1M'));
        $refreshToken = $this->refreshTokenRepository->createToken($accessToken, $expiryDateTime);

        return $responseBuilder->success($this->token, $accessToken, $refreshToken, $scopes);
    }

    /**
     * @param Request $request
     * @return ClientEntity
     * @throws AuthorizationServerException
     */
    private function validateClient(Request $request)
    {
        $clientId = $request->get('client_id');
        $clientSecret = $request->get('client_secret');

        $client = $this->clientRepository->getClient($clientId);

        if ($client instanceof ClientEntity === false) {
            throw new AuthorizationServerException('The requested client is unknown.', null, null, 'invalid_client');
        }

        if ($client->getSecret() !== $clientSecret) {
            throw new AuthorizationServerException(
                'The given client_secret does not match the client.',
                null,
                null,
                'invalid_client'
            );
        }

        if (!in_array($this->getIdentifier(), $client->getGrantTypes())) {
            throw new AuthorizationServerException(
                'The authenticated client is not authorized to use this authorization grant type.',
                null,
                null,
                'unauthorized_client'
            );
        }

        // TODO: check if validating the uri is necessary here, should be irrelevant for password credentials grant
        // TODO: might be necessary if this will be used for multiple grants though

        return $client;
    }

    /**
     * @param Request $request
     * @return ScopeEntity[]
     */
    private function validateScopes(Request $request)
    {
        $scopeParameter = $request->get('scope');
        $scopeIdentifiers = explode(' ', $scopeParameter);

        $scopes = $this->scopeRepository->getScopes($scopeIdentifiers);

        return $scopes;
    }

    private function validateUser(Request $request)
    {
        $username = $request->get('username');
        $password = $request->get('password');

        $user = $this->userRepository->getUser($username, $password);

        if ($user instanceof UserEntity === false) {
            // TODO: check how to correctly handle invalid user credentials, the rfc doesn't really guide that case
            throw new AuthorizationServerException('The given user credentials are invalid.', null, null, 'invalid_user_credentials');
        }

        return $user;
    }

    /**
     * @return string
     */
    private function getIdentifier()
    {
        return 'password';
    }
}
