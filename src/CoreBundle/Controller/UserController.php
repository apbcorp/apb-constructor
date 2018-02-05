<?php

namespace CoreBundle\Controller;

use CoreBundle\BaseClasses\BaseController;
use CoreBundle\Container\CookieContainer;
use CoreBundle\Entity\User;
use CoreBundle\Service\TokenService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class UserController extends BaseController
{
    /**
     * @Route("/v1.0/login")
     * @Method("POST")
     */
    public function loginAction(Request $request) : JsonResponse
    {
        $params = [
            'username' => $request->request->get('username'),
            'password' => md5($request->request->get('password')),
            'isActive' => true
        ];

        /** @var User $user */
        $user = $this->getDoctrine()->getManager()->getRepository(User::class)->findOneBy($params);

        if (!$user) {
            return $this->buildResponse('user not found', Response::HTTP_FORBIDDEN, true);
        }

        /** @var TokenService $tokenService */
        $tokenService = $this->get('core.service.token');
        $token = $tokenService->generateNewToken($user);

        /** @var CookieContainer $cookieContainer */
        $cookieContainer = $this->get('core.container.cookie');
        $cookieContainer->add('token', $token);

        return $this->buildResponse($user, Response::HTTP_OK);
    }
}