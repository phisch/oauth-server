<?php

namespace Phisch90\OAuth\Server\Grant;

use Phisch90\OAuth\Server\Entity\ClientEntity;
use Phisch90\OAuth\Server\Entity\ScopeEntity;
use Phisch90\OAuth\Server\Entity\UserEntity;
use Phisch90\OAuth\Server\Repository\AccessTokenRepository;
use Phisch90\OAuth\Server\Repository\ClientRepository;
use Phisch90\OAuth\Server\Repository\RefreshTokenRepository;
use Phisch90\OAuth\Server\Repository\ScopeRepository;
use Phisch90\OAuth\Server\Repository\UserRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
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
     * @param ClientRepository $clientRepository
     * @param ScopeRepository $scopeRepository
     * @param UserRepository $userRepository
     * @param AccessTokenRepository $accessTokenRepository
     * @param RefreshTokenRepository $refreshTokenRepository
     */
    public function __construct(
        ClientRepository $clientRepository,
        ScopeRepository $scopeRepository,
        UserRepository $userRepository,
        AccessTokenRepository $accessTokenRepository,
        RefreshTokenRepository $refreshTokenRepository
    ) {
        $this->clientRepository = $clientRepository;
        $this->scopeRepository = $scopeRepository;
        $this->userRepository = $userRepository;
        $this->accessTokenRepository = $accessTokenRepository;
        $this->refreshTokenRepository = $refreshTokenRepository;
    }

    /**
     * @param Request $request
     * @return bool
     */
    public function supports(Request $request)
    {
        return $request->get('grant_type') === $this->getIdentifier();
    }

    public function handle(Request $request)
    {
        $client = $this->validateClient($request);
        $scopes = $this->validateScopes($request);
        $user = $this->validateUser($request);

        // check if scopes fit for client


        $expiryDateTime = (new \DateTime())->add(new \DateInterval('PT1H'));
        $accessToken = $this->accessTokenRepository->createToken($client, $user, $scopes, $expiryDateTime);

        $expiryDateTime = (new \DateTime())->add(new \DateInterval('P1M'));
        $refreshToken = $this->refreshTokenRepository->createToken($accessToken, $expiryDateTime);

        // generate response

        $responseJson = [
            'access_token' => $accessToken->getIdentifier(),
            'token_type' => $this->getIdentifier(),
            'expires_in' => $accessToken->getExpiryDateTime()->getTimestamp() - (new \DateTime())->getTimestamp(),
            'refresh_token' => $refreshToken->getIdentifier(),
            'scope' => $this->generateScopeList($scopes)
        ];


        $response = new JsonResponse(
            $responseJson
        );

        return $response;
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

    /**
     * @param Request $request
     * @return ClientEntity
     */
    private function validateClient(Request $request)
    {
        $clientId = $request->get('client_id');
        $clientSecret = $request->get('client_secret');

        $client = $this->clientRepository->getClient($clientId, $clientSecret, $this->getIdentifier());

        if ($client instanceof ClientEntity === false) {
            // throw invalid client exception
        }

        // check if redirect uri matches

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
            // throw invalid credentials exception
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
