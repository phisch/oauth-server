<?php

namespace Phisch\OAuth\Server\Entity;

interface RefreshTokenEntityInterface
{
    /**
     * @return string
     */
    public function getIdentifier();
}
