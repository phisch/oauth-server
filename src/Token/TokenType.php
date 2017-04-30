<?php

namespace Phisch\OAuth\Server\Token;

use Phisch\OAuth\Server\Entity\AccessTokenEntity;

interface TokenType
{
    /**
     * @param AccessTokenEntity $accessToken
     * @return string
     */
    public function generate(AccessTokenEntity $accessToken);

    /**
     * @return string
     */
    public function getType();
}
