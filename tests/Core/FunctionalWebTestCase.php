<?php

namespace Tests\Core;

use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpKernel\Client;
use Tests\Fixtures\MySqlFixtureInterface;

class FunctionalWebTestCase extends WebTestCase
{
    /** @var string */
    protected $token = '';

    /** @var Client */
    private $client;

    /** @var  EntityManager */
    private $entityManager;

    /** @var ContainerInterface */
    private $container;

    protected function getClient() : Client
    {
        if (!$this->client) {
            $this->client = $this->createClient();
        }

        return $this->client;
    }

    protected function getContainer() : ContainerInterface
    {
        if (!$this->container) {
            self::bootKernel(['environment' => 'test']);

            $this->container = self::$kernel->getContainer();
        }

        return $this->container;
    }

    protected function getEntityManager() : EntityManager
    {
        if (!$this->entityManager) {
            $this->entityManager = $this->getContainer()->get('doctrine.orm.entity_manager');
        }

        return $this->entityManager;
    }

    protected function loadFixtures(array $fixtures) : void
    {
        foreach ($fixtures as $fixture) {
            if (!$fixture instanceof MySqlFixtureInterface) {
                throw new \Exception('Fixture must implement MySqlFixtureInterface');
            }

            $fixture->truncate($this->getEntityManager());
            $fixture->truncate($this->getEntityManager());
        }
    }
}