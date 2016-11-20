<?php

namespace Phisch90\OAuth\Server\Entity;

interface AccessTokenEntity
{
    /**
     * @return string
     */
    public function getIdentifier();

    /**
     * @return ClientEntity
     */
    public function getClient();

    /**
     * @return UserEntity
     */
    public function getUser();

    /**
     * @return ScopeEntity[]
     */
    public function getScopes();

    /**
     * @return \DateTime
     */
    public function getExpiryDateTime();
}
