<?php

namespace Phisch90\OAuth\Server\Repository;

use Phisch90\OAuth\Server\Entity\AccessTokenEntity;
use Phisch90\OAuth\Server\Entity\ClientEntity;
use Phisch90\OAuth\Server\Entity\UserEntity;

interface AccessTokenRepository
{
    /**
     * @param ClientEntity $client
     * @param UserEntity $user
     * @param \DateTime $expires
     * @return AccessTokenEntity
     */
    public function createToken(ClientEntity $client, UserEntity $user, \DateTime $expires);
}
