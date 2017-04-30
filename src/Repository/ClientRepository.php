<?php

namespace Phisch\OAuth\Server\Repository;

use Phisch\OAuth\Server\Entity\ClientEntity;

interface ClientRepository
{
    /**
     * @param string $clientId
     * @return ClientEntity
     */
    public function getClient($clientId);
}
