<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class DefaultController extends Controller
{
    public function getPlacesAction(Request $request)
    {
        $token = $this->getToken();
        $url = $this->generateUrl(
            'api_get_places', 
            array(), 
            UrlGeneratorInterface::ABSOLUTE_URL
        );
        $query = $url . '?lat=54.348511&lng=18.653256&type=bar&radius=2000';
        $response = $this->getClient()->get(
            $query, 
            array(
                CURLOPT_HTTPHEADER => array('Authorization: Bearer ' . $token)
            )
        )->getContent();
        
        return $this->render(
            'client/list.html.twig',
            array(
                'places' => json_decode($response),
                'headline' => "Bars located within 2km radius around Neptune's Fountain"
            )
        );
    }

    public function getPlaceByIdAction($id)
    {
        $token = $this->getToken();
        $url = $this->generateUrl(
            'api_get_place', 
            array('id' => $id), 
            UrlGeneratorInterface::ABSOLUTE_URL
        );
        $response = $this->getClient()->get(
            $url, 
            array(
                CURLOPT_HTTPHEADER => array('Authorization: Bearer ' . $token)
            )
        )->getContent();
        
        return $this->render(
            'client/details.html.twig',
            array(
                'place' => json_decode($response)
            )
        );
    }

    public function getSavedPlacesAction(Request $request)
    {
        $token = $this->getToken();
        $url = $this->generateUrl(
            'api_get_saved_places', 
            array(), 
            UrlGeneratorInterface::ABSOLUTE_URL
        );
        $response = $this->getClient()->get(
            $url, 
            array(
                CURLOPT_HTTPHEADER => array('Authorization: Bearer ' . $token)
            )
        )->getContent();

        return $this->render(
            'client/saved_list.html.twig',
            array(
                'places' => json_decode($response)
            )
        );
    }

    public function getPlacesByPlaceIdAction($id)
    {
        $token = $this->getToken();

        $getSavedPlaceUrl = $this->generateUrl(
            'api_get_saved_place', 
            array('id' => $id), 
            UrlGeneratorInterface::ABSOLUTE_URL
        );
        $response = $this->getClient()->get(
            $getSavedPlaceUrl, 
            array(
                CURLOPT_HTTPHEADER => array('Authorization: Bearer ' . $token)
            )
        )->getContent();
        $place = json_decode($response);

        $getPlacesUrl = $this->generateUrl(
            'api_get_places', 
            array(), 
            UrlGeneratorInterface::ABSOLUTE_URL
        );
        $response = $this->getClient()->get(
            $getPlacesUrl . 
            "?lat=" . 
            $place->latitude . 
            "&lng=" . 
            $place->longitude . 
            "&type=bar&radius=2000", 
            array(
                CURLOPT_HTTPHEADER => array('Authorization: Bearer ' . $token)
            )
        )->getContent();
        
        return $this->render('client/list.html.twig',
            array(
                'places' => json_decode($response),
                'headline' => sprintf(
                    'Bars located within 2 km radius around location (%f, %f)', 
                    $place->latitude, 
                    $place->longitude
                )
            )
        );
    }

    private function getClient()
    {
        return $this->container->get('circle.restclient');
    }

    private function getToken()
    {
        $credentials = array('_username' => 'test', '_password' => 'test12345');

        $credentialsString = json_encode($credentials);

        $url = $this->generateUrl(
            'api_login_check', 
            array(), 
            UrlGeneratorInterface::ABSOLUTE_URL
        );

        $response = $this->getClient()->post(
            $url, 
            $credentialsString,
            array(
                CURLOPT_HTTPHEADER => 
                    array(
                        'Content-Type: application/json',                             
                        'Content-Length: ' . 
                            strlen($credentialsString)
                    )     
            )
        );

        $encodedResponse = json_decode(
            $response->getContent()
        );

        if(!isset($encodedResponse->token))
            throw new AccessDeniedException();

        return $encodedResponse->token;

    }


}
