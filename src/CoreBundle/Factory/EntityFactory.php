<?php

namespace CoreBundle\Factory;

use CoreBundle\Entity\Token;

class EntityFactory
{
    public function createToken() : Token
    {
        return new Token();
    }
}