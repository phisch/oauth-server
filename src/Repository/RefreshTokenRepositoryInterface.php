<?php

namespace Phisch\OAuth\Server\Repository;

use Phisch\OAuth\Server\Entity\AccessTokenEntityInterface;
use Phisch\OAuth\Server\Entity\RefreshTokenEntityInterface;

interface RefreshTokenRepositoryInterface
{
    /**
     * @param AccessTokenEntityInterface $accessTokenEntity
     * @param \DateTime $expiryDateTime
     * @return RefreshTokenEntityInterface
     */
    public function createToken(AccessTokenEntityInterface $accessTokenEntity, \DateTime $expiryDateTime);
}
