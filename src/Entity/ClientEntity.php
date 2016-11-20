<?php

namespace Phisch90\OAuth\Server\Entity;

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
