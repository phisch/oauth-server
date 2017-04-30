<?php

namespace Phisch\OAuth\Server\Entity;

interface ClientEntity
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
