<?php

namespace Phisch90\OAuth\Server\Repository;

use Phisch90\OAuth\Server\Entity\ClientEntity;

interface UserRepository
{
    /**
     * @param string $username
     * @param string $password
     * @return ClientEntity
     */
    public function getUser($username, $password);
}
