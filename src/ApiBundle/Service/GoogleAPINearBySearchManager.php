<?php
namespace ApiBundle\Service;

use Circle\RestClientBundle\Services\RestClient;

use ApiBundle\Service\GoogleAPIManager;
use ApiBundle\Entity\Coordinates;
use ApiBundle\Util\GoogleAPIClient;
use ApiBundle\Util\NearBySearchGoogleQueryImpl;


class GoogleAPINearBySearchManager implements GoogleAPIManager
{

    const BASE_URL = 'https://maps.googleapis.com/maps/api/place/nearbysearch/';

	private $restClient;
    private $client;
    private $apiKey;

	public function __construct($apiKey, RestClient $restClient)
	{
		$this->restClient = $restClient;
        $this->apiKey = $apiKey;
        $this->client = new GoogleAPIClient(self::BASE_URL, $restClient);
        $this->preconfigure();
	}

    public function preconfigure()
    {
        $this->client->setKey($this->apiKey);
        $this->client->setFormat('json');
    }

    public function get(Coordinates $location, $type, $radius)
    {
        $this->client->setQuery(new NearBySearchGoogleQueryImpl($location, $type, $radius));
        $this->client->send();
        return $this->client->getResponse();
    }

}
