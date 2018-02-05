<?php

namespace CoreBundle\EventListner;

use CoreBundle\Container\CookieContainer;
use CoreBundle\Service\TokenService;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Http\Firewall\ListenerInterface;

class AccessListner implements ListenerInterface
{
    const INVALID_ACCESS_TOKEN = 'Invalid access token';
    const EMPTY_ACCESS_TOKEN = 'Empty access token';
    
    /**
     * @var EntityManager
     */
    private $entityManager;
    
    /**
     * @var TokenStorage
     */
    private $securityContext;
    
    /**
     * @var TokenService
     */
    private $tokenService;
    
    /**
     * AccessListner constructor.
     * @param EntityManager $entityManager
     * @param TokenStorage $securityContext
     * @param TokenService $tokenService
     */
    public function __construct(EntityManager $entityManager, TokenStorage $securityContext, TokenService $tokenService)
    {
        $this->entityManager = $entityManager;
        $this->securityContext = $securityContext;
        $this->tokenService = $tokenService;
    }
    
    public function handle(GetResponseEvent $event)
    {
        $accessToken = $event->getRequest()->cookies->get('token');
        if (!$accessToken) {
            $event->setResponse(new JsonResponse(['error' => self::EMPTY_ACCESS_TOKEN], JsonResponse::HTTP_FORBIDDEN));
            return;
        }
        $token = $this->tokenService->getTokenEntity($accessToken);
        if (!$token) {
            $event->setResponse(new JsonResponse(['error' => self::INVALID_ACCESS_TOKEN], JsonResponse::HTTP_FORBIDDEN));
            return;
        }
        $user = $token->getUser();
        $usernamePasswordToken = new UsernamePasswordToken($user, $user->getPassword(), "main", []);
        $this->securityContext->setToken($usernamePasswordToken);
    }
}