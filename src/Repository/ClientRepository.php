<?php

namespace Phisch90\OAuth\Server\Repository;

use Phisch90\OAuth\Server\Entity\ClientEntity;

interface ClientRepository
{
    /**
     * @param string $clientId
     * @param string $clientSecret
     * @param string $grantName
     * @return ClientEntity
     */
    public function getClient($clientId, $clientSecret, $grantName);
}
