<?php

namespace Phisch\OAuth\Server\Grant;

use Phisch\OAuth\Server\Entity\ClientEntityInterface;
use Phisch\OAuth\Server\Entity\ScopeEntityInterface;
use Phisch\OAuth\Server\Entity\UserEntityInterface;
use Phisch\OAuth\Server\Exception\AuthorizationServerException;
use Phisch\OAuth\Server\Repository\AccessTokenRepositoryInterface;
use Phisch\OAuth\Server\Repository\ClientRepositoryInterface;
use Phisch\OAuth\Server\Repository\RefreshTokenRepositoryInterface;
use Phisch\OAuth\Server\Repository\ScopeRepositoryInterface;
use Phisch\OAuth\Server\Repository\UserRepositoryInterface;
use Phisch\OAuth\Server\Response\ResponseBuilderInterface;
use Phisch\OAuth\Server\Token\TokenTypeInterface;
use Symfony\Component\HttpFoundation\Request;

class AuthorizationCodeGrant implements AuthorizationGrantInterface
{

    /**
     * @var ClientRepositoryInterface
     */
    private $clientRepository;

    /**
     * @var ScopeRepositoryInterface
     */
    private $scopeRepository;

    /**
     * @var UserRepositoryInterface
     */
    private $userRepository;

    /**
     * @var AccessTokenRepositoryInterface
     */
    private $accessTokenRepository;

    /**
     * @var RefreshTokenRepositoryInterface
     */
    private $refreshTokenRepository;

    /**
     * @var TokenTypeInterface
     */
    private $token;

    /**
     * @param ClientRepositoryInterface $clientRepository
     * @param ScopeRepositoryInterface $scopeRepository
     * @param UserRepositoryInterface $userRepository
     * @param AccessTokenRepositoryInterface $accessTokenRepository
     * @param RefreshTokenRepositoryInterface $refreshTokenRepository
     * @param TokenTypeInterface $token
     */
    public function __construct(
        ClientRepositoryInterface $clientRepository,
        ScopeRepositoryInterface $scopeRepository,
        UserRepositoryInterface $userRepository,
        AccessTokenRepositoryInterface $accessTokenRepository,
        RefreshTokenRepositoryInterface $refreshTokenRepository,
        TokenTypeInterface $token
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
        return $request->get('response_type') === $this->getIdentifier();
    }

    /**
     * @param Request $request
     * @param ResponseBuilderInterface $responseBuilder
     * @return mixed
     */
    public function handle(Request $request, ResponseBuilderInterface $responseBuilder)
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
     * @return ClientEntityInterface
     * @throws AuthorizationServerException
     */
    private function validateClient(Request $request)
    {
        $clientId = $request->get('client_id');
        $clientSecret = $request->get('client_secret');

        $client = $this->clientRepository->getClient($clientId);

        if ($client instanceof ClientEntityInterface === false) {
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
     * @return ScopeEntityInterface[]
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

        if ($user instanceof UserEntityInterface === false) {
            // TODO: check how to correctly handle invalid user credentials, the rfc doesn't really guide that case
            throw new AuthorizationServerException(
                'The given user credentials are invalid.',
                null,
                null,
                'invalid_user_credentials'
            );
        }

        return $user;
    }

    /**
     * @return string
     */
    private function getIdentifier()
    {
        return 'code';
    }

    public function cancel()
    {
        // TODO: Implement cancel() method.
    }

    public function validate(Request $request)
    {
        //throw new AuthorizationServerException('fuck fuck fuck',0, null, 'yeah, something went horribly wrong!');
    }


}
