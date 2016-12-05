<?php

namespace Phisch90\OAuth\Server\Token;

use Phisch90\OAuth\Server\Entity\AccessTokenEntity;

class BearerToken implements TokenType
{
    /**
     * @param AccessTokenEntity $accessToken
     * @return string
     */
    public function generate(AccessTokenEntity $accessToken)
    {
        return $accessToken->getIdentifier();
    }

    /**
     * @return string
     */
    public function getType()
    {
        return 'Bearer';
    }
}
