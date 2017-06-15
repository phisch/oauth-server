<?php

namespace Phisch\OAuth\Server\Token;

use Phisch\OAuth\Server\Entity\AccessTokenEntityInterface;

class BearerToken implements TokenTypeInterface
{
    /**
     * @param AccessTokenEntityInterface $accessToken
     * @return string
     */
    public function generate(AccessTokenEntityInterface $accessToken)
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
