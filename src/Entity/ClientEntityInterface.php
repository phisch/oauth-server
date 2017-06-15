<?php

namespace Phisch\OAuth\Server\Entity;

interface ClientEntityInterface
{
    /**
     * @return array
     */
    public function getGrantTypes();

    /**
     * @return string
     */
    public function getSecret();
}
