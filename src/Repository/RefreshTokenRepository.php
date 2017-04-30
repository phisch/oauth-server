<?php

namespace Phisch\OAuth\Server\Repository;

use Phisch\OAuth\Server\Entity\AccessTokenEntity;
use Phisch\OAuth\Server\Entity\RefreshTokenEntity;

interface RefreshTokenRepository
{
    /**
     * @param AccessTokenEntity $accessTokenEntity
     * @param \DateTime $expiryDateTime
     * @return RefreshTokenEntity
     */
    public function createToken(AccessTokenEntity $accessTokenEntity, \DateTime $expiryDateTime);
}
