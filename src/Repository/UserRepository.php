<?php

namespace Phisch\OAuth\Server\Repository;

use Phisch\OAuth\Server\Entity\UserEntity;

interface UserRepository
{
    /**
     * @param string $username
     * @param string $password
     * @return UserEntity
     */
    public function getUser($username, $password);
}
