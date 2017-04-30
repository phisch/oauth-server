<?php

namespace Phisch\OAuth\Server\Entity;

interface RefreshTokenEntity
{
    /**
     * @return string
     */
    public function getIdentifier();
}
