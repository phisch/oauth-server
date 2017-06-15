<?php

namespace Phisch\OAuth\Server\Repository;

use Phisch\OAuth\Server\Entity\ScopeEntityInterface;

interface ScopeRepositoryInterface
{
    /**
     * @param string $identifier
     * @return ScopeEntityInterface
     */
    public function getScope($identifier);

    /**
     * @param array $identifiers
     * @return ScopeEntityInterface[]
     */
    public function getScopes(array $identifiers);
}
