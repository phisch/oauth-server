<?php

namespace Phisch90\OAuth\Server\Repository;

use Phisch90\OAuth\Server\Entity\ScopeEntity;

interface ScopeRepository
{
    /**
     * @param string $identifier
     * @return ScopeEntity
     */
    public function getScope($identifier);

    /**
     * @param array $identifiers
     * @return ScopeEntity
     */
    public function getScopes(array $identifiers);
}
