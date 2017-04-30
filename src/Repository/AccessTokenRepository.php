<?php

namespace Phisch\OAuth\Server\Repository;

use Phisch\OAuth\Server\Entity\AccessTokenEntity;
use Phisch\OAuth\Server\Entity\ClientEntity;
use Phisch\OAuth\Server\Entity\ScopeEntity;
use Phisch\OAuth\Server\Entity\UserEntity;

interface AccessTokenRepository
{
    /**
     * @param ClientEntity $client
     * @param UserEntity $user
     * @param ScopeEntity[] $scopes
     * @param \DateTime $expires
     * @return AccessTokenEntity
     */
    public function createToken(ClientEntity $client, UserEntity $user, array $scopes, \DateTime $expires);
}
