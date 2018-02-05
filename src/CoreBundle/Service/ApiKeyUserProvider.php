<?php

namespace CoreBundle\Service;

use CoreBundle\Entity\Token;
use CoreBundle\Entity\User;
use Doctrine\ORM\EntityManager;
use Symfony\Bridge\Doctrine\DependencyInjection\Security\UserProvider\EntityFactory;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class ApiKeyUserProvider implements UserProviderInterface
{
    /** @var EntityManager */
    private $entityManager;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }
    
    public function getUsernameForApiKey($apiKey)
    {
        $username = $this->entityManager->getRepository(Token::class)->findOneBy(['token' => $apiKey]);

        return $username;
    }
    
    public function loadUserByUsername($username)
    {
        return new User(
            $username,
            null,
            []
        );
    }
    
    public function refreshUser(UserInterface $user)
    {
        throw new UnsupportedUserException();
    }
    
    public function supportsClass($class)
    {
        return User::class === $class;
    }
}