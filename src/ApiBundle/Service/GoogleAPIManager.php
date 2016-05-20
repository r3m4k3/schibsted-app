<?php
namespace ApiBundle\Service;

use Circle\RestClientBundle\Services\RestClient;

interface GoogleAPIManager
{
	public function __construct($apiKey, RestClient $restClient);
    public function preconfigure();
}
