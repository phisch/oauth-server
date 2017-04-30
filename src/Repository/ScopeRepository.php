<?php

namespace Phisch\OAuth\Server\Repository;

use Phisch\OAuth\Server\Entity\ScopeEntity;

interface ScopeRepository
{
    /**
     * @param string $identifier
     * @return ScopeEntity
     */
    public function getScope($identifier);

    /**
     * @param array $identifiers
     * @return ScopeEntity[]
     */
    public function getScopes(array $identifiers);
}
