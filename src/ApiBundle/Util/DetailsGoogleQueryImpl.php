<?php

namespace ApiBundle\Util;

use ApiBundle\Util\GoogleAPIQuery;

class DetailsGoogleQueryImpl implements GoogleAPIQuery
{

	private $placeid;

	public function __construct($placeid)
	{
		$this->placeid = $placeid;
	}

	public function __toString()
	{
		return http_build_query($this);
	}

}