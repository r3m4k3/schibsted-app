<?php

namespace Tests\ApiBundle\Controller;

use Tests\ApiBundle\AuthorizedTestCase;

class SavedObjectControllerTest extends AuthorizedTestCase
{

    protected $client = null;

    public function setUp()
    {
        $this->client = static::createClient();
    }
       
    public function test_get_all_saved_objects_without_authorization()
    {
        $url = $this->client->getContainer()->get('router')->generate('api_get_saved_places', array(), false);
        $this->client->request('GET', $url);
        $this->assertEquals(401, $this->client->getResponse()->getStatusCode());
    }

    public function test_get_saved_object_without_authorization()
    {
        $url = $this->client->getContainer()->get('router')->generate('api_get_saved_place', array('id' => 1), false);
        $this->client->request('GET', $url);
        $this->assertEquals(401, $this->client->getResponse()->getStatusCode());
    }

    public function test_create_saved_object_without_authorization()
    {
        $url = $this->client->getContainer()->get('router')->generate('api_save_new_place', array(), false);
        $this->client->request('POST', $url);
        $this->assertEquals(401, $this->client->getResponse()->getStatusCode());
    }

    public function test_remove_saved_object_without_authorization()
    {
        $url = $this->client->getContainer()->get('router')->generate('api_delete_saved_place', array('id' => 1), false);
        $this->client->request('DELETE', $url);
        $this->assertEquals(401, $this->client->getResponse()->getStatusCode());
    }

    public function test_create_saved_object_with_authorization()
    {
        $client = parent::createAuthenticatedClient();
        $url = $client->getContainer()->get('router')->generate('api_save_new_place', array(), false);
        $client->request('POST', $url, array('lat' => 11.4567, 'lng' => 15.05));
        $this->assertEquals(201, $client->getResponse()->getStatusCode());
    }

}
