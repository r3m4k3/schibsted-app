<?php

namespace ApiBundle\Controller;

use Symfony\Component\HttpFoundation\Request;

use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;

use ApiBundle\Entity\Coordinates;

class SavedPlaceController extends FOSRestController
{

    /**
     * @Rest\View(statusCode=201)
     */
    public function newAction(Request $request)
    {  
        $coordinatesData = $this->getDataFromParamRequest($request);

        $coordinates = new Coordinates(
            $coordinatesData['latitude'], 
            $coordinatesData['longitude']
        );
        
        $this->get('coordinates_manager')->add($coordinates);
    }

    /**
     * @Rest\View
     */
    public function allAction()
    {
        return $this->get('coordinates_manager')->findAll();
    }

    /**
     * @Rest\View
     */
    public function getAction($id)
    {
        return $this->get('coordinates_manager')->find($id);
    }

    /**
     * @Rest\View(statusCode=204)
     */
    public function removeAction(Coordinates $coordinates)
    {
        $this->get('coordinates_manager')->remove($coordinates);
    }

    private function getDataFromParamRequest(Request $request)
    {
        return array(
            'latitude' => $request->request->get('lat'),
            'longitude' => $request->request->get('lng')
        );    
    }

}
