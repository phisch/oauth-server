<?php

namespace Phisch\OAuth\Server\Entity;

interface AccessTokenEntityInterface
{
    /**
     * @return string
     */
    public function getIdentifier();

    /**
     * @return ClientEntityInterface
     */
    public function getClient();

    /**
     * @return UserEntityInterface
     */
    public function getUser();

    /**
     * @return ScopeEntityInterface[]
     */
    public function getScopes();

    /**
     * @return \DateTime
     */
    public function getExpiryDateTime();
}
