<?php

namespace Tests\ApiBundle;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AuthorizedTestCase extends WebTestCase
{

    public static function createAuthenticatedClient($username = 'test', $password = 'test12345')
    {
        $client = static::createClient();
        $url = $client->getContainer()->get('router')->generate('api_login_check', array(), false);
        $client->request(
            'POST',
            $url,
            array(
                '_username' => $username,
                '_password' => $password,
            )
        );

        $data = json_decode($client->getResponse()->getContent(), true);

        $client = static::createClient();
        $client->setServerParameter('HTTP_Authorization', sprintf('Bearer %s', $data['token']));

        return $client;
    }

}