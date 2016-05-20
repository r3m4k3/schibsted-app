<?php

namespace Tests\ApiBundle\Controller;

use Tests\ApiBundle\AuthorizedTestCase;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends AuthorizedTestCase
{
	protected $client = null;

    public function setUp()
    {
        $this->client = static::createClient();
    }

    public function test_get_all_items_without_authorization()
    {
        $url = $this->client->getContainer()->get('router')->generate('api_get_places', array(), false);
        $this->client->request('GET', $url);
        $this->assertEquals(401, $this->client->getResponse()->getStatusCode());
    }

    public function test_get_item_without_authorization()
    {
        $url = $this->client->getContainer()->get('router')->generate('api_get_place', array('id' => 1), false);
        $this->client->request('GET', $url);
        $this->assertEquals(401, $this->client->getResponse()->getStatusCode());
    }

    public function test_get_all_items_with_authorization()
	{
		$client = parent::createAuthenticatedClient();
		$url = $client->getContainer()->get('router')->generate('api_get_places', array(), false);
	    $client->request('GET', $url);
	    $this->assertEquals(200, $client->getResponse()->getStatusCode());
	}

    public function test_get_item_with_authorization_fail()
    {
        $this->client->setServerParameter('HTTP_Authorization', 'Bearer lol');
        $url = $this->client->getContainer()->get('router')->generate('api_get_places', array(), false);
        $this->client->request('GET', $url);
        $this->assertEquals(401, $this->client->getResponse()->getStatusCode());
    }

	public function test_get_all_items_with_authorization_when_place_exists()
	{
	    $client = parent::createAuthenticatedClient();
		$url = $client->getContainer()->get('router')->generate('api_get_place', array('id' => 'ChIJK1eQ_HVz_UYR9Qd93r5LqA4'), false);
	    $client->request('GET', $url);
	    $this->assertEquals(200, $client->getResponse()->getStatusCode());
	}

    /* status: INVALID_REQUEST */
	public function test_get_all_items_with_authorization_when_place_does_not_exist()
	{
	    $client = parent::createAuthenticatedClient();
		$url = $client->getContainer()->get('router')->generate('api_get_place', array('id' => '1'), false);
	    $client->request('GET', $url);
	    $this->assertEquals(500, $client->getResponse()->getStatusCode());
	}

}
