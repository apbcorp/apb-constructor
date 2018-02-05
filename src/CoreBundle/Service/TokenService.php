<?php

namespace CoreBundle\Service;

use CoreBundle\Entity\Token;
use CoreBundle\Entity\User;
use CoreBundle\Factory\EntityFactory;
use Doctrine\ORM\EntityManager;

class TokenService
{
    private $secret = 'APB Incorporated';
    
    /**
     * @var EntityManager
     */
    private $em;
    
    /**
     * @var EntityFactory
     */
    private $entityFactory;
    
    /**
     * @var Token
     */
    private $entity;
    
    public function __construct(EntityManager $em, EntityFactory $entityFactory)
    {
        $this->em = $em;
        $this->entityFactory = $entityFactory;
    }
    /**
     * @param User $user
     * @return string
     */
    public function generateNewToken(User $user) : string
    {
        $this->destroyCurrentToken();

        do {
            $params = [
                $user->getUsername(),
                $user->getPassword(),
                date('Y-m-d H:i:s', time() + 3600),
                rand(11, 23)
            ];

            $token = md5(implode($this->secret, $params));
            $entity = $this->em->getRepository(Token::class)->findOneBy(['token' => $token]);
        } while (!empty($entity));

        $this->entity = $this->getOrCreateTokenEntity($user);
        $this->entity->setUser($user)
            ->setToken($token)
            ->setExpirationDate($this->getNewExpirationDate());

        $this->saveToken();

        return $token;
    }

    /**
     * @return bool
     */
    public function destroyCurrentToken() : bool
    {
        if (!$this->entity) {
            return false;
        }
        $this->entity->setExpirationDate(new \DateTime('-1 day'));

        $this->saveToken();

        return true;
    }

    /**
     * @param string $token
     * @return Token
     */
    public function getTokenEntity($token = '')
    {
        if ($token) {
            $this->entity = $this->em->getRepository(Token::class)->findOneBy(['token' => $token]);
        }

        return $this->entity;
    }

    private function getOrCreateTokenEntity(User $user) : Token
    {
        $tokenEntity = $this->em->getRepository(Token::class)->find($user->getId());

        if (!$tokenEntity) {
            $tokenEntity = $this->entityFactory->createToken();
        }

        return $tokenEntity;
    }

    /**
     * @return \DateTime
     */
    private function getNewExpirationDate() : \DateTime
    {
        return new \DateTime(Token::LIFETIME);
    }

    private function saveToken() : void
    {
        $this->em->persist($this->entity);
        $this->em->flush();
    }
}