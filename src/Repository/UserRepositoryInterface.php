<?php

namespace Phisch\OAuth\Server\Repository;

use Phisch\OAuth\Server\Entity\UserEntityInterface;

interface UserRepositoryInterface
{
    /**
     * @param string $username
     * @param string $password
     * @return UserEntityInterface
     */
    public function getUser($username, $password);
}
