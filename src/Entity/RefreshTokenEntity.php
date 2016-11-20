<?php

namespace Phisch90\OAuth\Server\Entity;

interface RefreshTokenEntity
{
    /**
     * @return string
     */
    public function getIdentifier();
}
