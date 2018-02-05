<?php

namespace Tests\Fixtures;

use CoreBundle\Entity\User;
use Doctrine\ORM\EntityManager;

class UserFixture implements MySqlFixtureInterface
{
    const ADMIN_LOGIN = 'admin';
    const ADMIN_PASS = 'admin';
    const ADMIN_MAIL = 'admin@test.com';
    
    const USER_LOGIN = 'user';
    const USER_PASS = 'user';
    const USER_MAIL = 'user@test.com';
    
    public function execute(EntityManager $entityManager) : void
    {
        $admin = new User();
        $admin->setIsDeveloper(true)
            ->setPassword(self::ADMIN_PASS)
            ->setSalt(User::SALT)
            ->setUsername(self::ADMIN_LOGIN)
            ->setMail(self::ADMIN_MAIL);

        $user = new User();
        $user->setPassword(self::USER_PASS)
            ->setIsDeveloper(false)
            ->setUsername(self::USER_LOGIN)
            ->setSalt(User::SALT)
            ->setMail(self::USER_MAIL);

        $entityManager->persist($admin);
        $entityManager->persist($user);

        $entityManager->flush();
    }
    
    public function truncate(EntityManager $entityManager) : void
    {
        $entityManager->getRepository(User::class)->clear();
    }
}