<?php

namespace Simplex;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\EventDispatcher\Event;

class ResponseEvent extends Event
{
	private $_request;
	private $_response;

	public function __construct(Response $response, Request $request)
	{
		$this->_request = $request;
		$this->_response = $response;
	}

	public function getResponse()
	{
		return $this->_response;
	}

	public function getRequest()
	{
		return $this->_request;
	}
}
