<?php

namespace ApiBundle\Util;

use ApiBundle\Entity\Coordinates;

use ApiBundle\Util\GoogleAPIQuery;

class NearBySearchGoogleQueryImpl implements GoogleAPIQuery
{

	// check out this https://developers.google.com/places/supported_types#table1
	const ACCOUNTING = 'accounting';
	const AIRPORT = 'airport';
	const AMUSEMENT = 'amusement_park';
	const AQUARIUM = 'aquarium';
	const ART = 'art_gallery';
	const ATM = 'atm';
	const BAKERY = 'bakery';
	const BANK = 'bank';
	const BAR = 'bar';
	// ...

	private $type;
	private $location;
	private $radius;

	public function __construct(Coordinates $coordinates, $type, $radius)
	{
		$this->location = (String) $coordinates;
		$this->type = $type;
		$this->radius = $radius;
	}

	public function __toString()
	{
		return http_build_query($this);
	}

}