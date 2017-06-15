<?php

namespace Phisch\OAuth\Server\Repository;

use Phisch\OAuth\Server\Entity\ClientEntityInterface;

interface ClientRepositoryInterface
{
    /**
     * @param string $clientId
     * @return ClientEntityInterface
     */
    public function getClient($clientId);
}
