<?php

namespace Tests\ApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AuthorizationTest extends WebTestCase
{

    public function testLoginSuccess()
    {
    	$client = static::createClient();
    	$loginData = array(
            '_username' => 'test',
            '_password' => 'test12345',
        );
        $url = $client->getContainer()->get('router')->generate('api_login_check', array(), false);
        $client->request('POST', $url, $loginData);
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $response = json_decode($client->getResponse()->getContent(), true);
        $this->assertArrayHasKey('token', $response);

    }

    public function testLoginFailure()
    {
    	$client = static::createClient();
    	$loginData = array(
            '_username' => 'testa',
            '_password' => 'test12345',
        );
        $url = $client->getContainer()->get('router')->generate('api_login_check', array(), false);
        $client->request('POST', $url, $loginData);
        $this->assertEquals(401, $client->getResponse()->getStatusCode());
    }

}
