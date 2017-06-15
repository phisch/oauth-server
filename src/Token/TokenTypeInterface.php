<?php

namespace Phisch\OAuth\Server\Token;

use Phisch\OAuth\Server\Entity\AccessTokenEntityInterface;

interface TokenTypeInterface
{
    /**
     * @param AccessTokenEntityInterface $accessToken
     * @return string
     */
    public function generate(AccessTokenEntityInterface $accessToken);

    /**
     * @return string
     */
    public function getType();
}
