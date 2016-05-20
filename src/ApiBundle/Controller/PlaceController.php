<?php

namespace ApiBundle\Controller;

use Symfony\Component\HttpFoundation\Request;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Request\ParamFetcherInterface;

use ApiBundle\Entity\Coordinates;
use ApiBundle\Entity\Place;

use ApiBundle\Util\NearBySearchGoogleQueryImpl;

class PlaceController extends FOSRestController
{

    /**
     * @Rest\View
     * @Rest\QueryParam(name="lat", description="Lat")
     * @Rest\QueryParam(name="lng", description="Lng")
     * @Rest\QueryParam(name="type", description="Type")
     * @Rest\QueryParam(name="radius", description="Radius")
     */
    public function allAction(ParamFetcherInterface $paramFetcher)
    {
        $attributes = $this->getDataFromParamFetcher($paramFetcher);
        $coordinates = $this->instantiateCoordinates($attributes['lat'], $attributes['lng']);
        $jsonResponse = $this->get('google_near_by_search.api')->get($coordinates, $attributes['type'], $attributes['radius']);

        return $this->parseArray($jsonResponse);
    }

    /**
     * @Rest\View
     */
    public function getAction($id)
    {
        $jsonResponse = $this->get('google_details.api')->get($id);

        return $this->parseItem($jsonResponse);  
    }

    private function getDataFromParamFetcher(ParamFetcherInterface $paramFetcher)
    {
        $attributes = array(
            'lat' => $paramFetcher->get('lat'),
            'lng' => $paramFetcher->get('lng'),
            'type' => $this->getInstanceType(
                $paramFetcher->get('type')
            ),
            'radius' => $paramFetcher->get('radius')
        );
        
        return $attributes;
    }

    private function instantiateCoordinates($latitude, $longitude)
    {
        return new Coordinates($latitude, $longitude);
    }

    private function parseArray($jsonResponse)
    {
        $results = array();
        $tmpArr = json_decode($jsonResponse)->results;

        foreach($tmpArr as $item) {
            $results[] = new Place(
                $item->place_id,
                $item->name,
                $this->instantiateCoordinates(
                    $item->geometry->location->lat, 
                    $item->geometry->location->lng
                )
            );
        }

        return $results;
    }

    private function parseItem($jsonResponse)
    {
        $item = json_decode($jsonResponse);

        return new Place(
            $item->result->id,
            $item->result->name,
            $this->instantiateCoordinates(
                $item->result->geometry->location->lat, 
                $item->result->geometry->location->lng
            ),
            $item->result->formatted_address
        );
    }

    private function getInstanceType($type)
    {
        $reflectAdapter = new \ReflectionClass('ApiBundle\Util\NearBySearchGoogleQueryImpl');

        return $reflectAdapter->getConstant(
            strtoupper($type)
        );

    }

}
