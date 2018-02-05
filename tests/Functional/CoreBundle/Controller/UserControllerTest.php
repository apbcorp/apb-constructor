<?php

namespace Tests\Functional\CoreBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Tests\Core\FunctionalWebTestCase;
use Tests\Fixtures\UserFixture;

class UserControllerTest extends FunctionalWebTestCase
{
    public function testGetAction()
    {

    }

    public function testLoginAction()
    {
        $this->loadFixtures([new UserFixture()]);
        
        $params = [
            'username' => UserFixture::ADMIN_LOGIN,
            'password' => UserFixture::ADMIN_PASS
        ];
        $this->getClient()->request(Request::METHOD_POST, '/v1.0/login', $params);

        $this->assertEquals(Response::HTTP_OK, $this->getClient()->getResponse()->getStatusCode());

        $result = json_decode($this->getClient()->getResponse()->getContent(), true);

        $this->assertEquals(UserFixture::ADMIN_LOGIN, $result['username']);
        $this->assertArrayNotHasKey('password', $result);
        $this->assertArrayNotHasKey('salt', $result);
        $this->assertArrayHasKey('isDeveloper', $result);
        $this->assertArrayHasKey('roles', $result);
        $this->assertArrayHasKey('permissions', $result);
    }

    public function testLogoutAction()
    {

    }

    public function testListAction()
    {

    }

    public function testAddAction()
    {

    }

    public function testEditAction()
    {

    }

    public function testDeleteAction()
    {

    }
}