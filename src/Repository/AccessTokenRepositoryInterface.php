<?php

namespace Phisch\OAuth\Server\Repository;

use Phisch\OAuth\Server\Entity\AccessTokenEntityInterface;
use Phisch\OAuth\Server\Entity\ClientEntityInterface;
use Phisch\OAuth\Server\Entity\ScopeEntityInterface;
use Phisch\OAuth\Server\Entity\UserEntityInterface;

interface AccessTokenRepositoryInterface
{
    /**
     * @param ClientEntityInterface $client
     * @param UserEntityInterface $user
     * @param ScopeEntityInterface[] $scopes
     * @param \DateTime $expires
     * @return AccessTokenEntityInterface
     */
    public function createToken(ClientEntityInterface $client, UserEntityInterface $user, array $scopes, \DateTime $expires);
}
