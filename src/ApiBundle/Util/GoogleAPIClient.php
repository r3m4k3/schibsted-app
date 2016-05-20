<?php

namespace ApiBundle\Util;

use Circle\RestClientBundle\Services\RestClient;

use ApiBundle\Util\GoogleAPIQuery;

final Class GoogleAPIClient
{

	private $key;

	private $query;

	private $baseUrl;

	private $format;

	private $requestURL;

	private $response;

	private $client;

	public function __construct($baseUrl, RestClient $restClient) 
	{
		$this->baseUrl = $baseUrl;
		$this->client = $restClient;
	}

	public function setKey($key)
	{
		$this->key = $key;
	}

	public function setFormat($format = 'json')
	{
		$this->format = $format;
	}

	public function setQuery(GoogleAPIQuery $query)
	{
		$this->query = $query;
	}

	private function createRequestURL()
	{
		$this->requestURL = 
				$this->baseUrl . 
				strtolower($this->format) . 
				'?' .  
				$this->query . 
				'&key=' . 
				$this->key;
	}

	public function send()
	{
		$this->createRequestURL();
		$this->response = $this->client->get($this->requestURL);
	}

	public function getResponse()
	{
		return $this->response->getContent();
	}

}