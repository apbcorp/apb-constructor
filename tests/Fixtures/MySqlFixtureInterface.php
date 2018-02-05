<?php

namespace Tests\Fixtures;

use Doctrine\ORM\EntityManager;

interface MySqlFixtureInterface
{
    public function execute(EntityManager $entityManager) : void;
    public function truncate(EntityManager $entityManager) : void;
}