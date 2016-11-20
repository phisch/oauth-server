<?php

namespace Phisch90\OAuth\Server\Repository;

use Phisch90\OAuth\Server\Entity\AccessTokenEntity;
use Phisch90\OAuth\Server\Entity\RefreshTokenEntity;

interface RefreshTokenRepository
{
    /**
     * @param AccessTokenEntity $accessTokenEntity
     * @param \DateTime $expiryDateTime
     * @return RefreshTokenEntity
     */
    public function createToken(AccessTokenEntity $accessTokenEntity, \DateTime $expiryDateTime);
}
