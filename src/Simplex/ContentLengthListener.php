<?php

namespace Simplex;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class ContentLengthListener implements EventSubscriberInterface
{
	public function onResponse(ResponseEvent $event)
	{
		$response = $event->getResponse();
		$headers = $response->headers;

		if (!$headers->has('Content-Length') && !$headers->has('Transfer-Encoding')) {
			$headers->set('Content-Length', strlen($response->getContent()));
		}
	}

	static function getSubscribedEvents()
	{
		return array('response' => 'onResponse', -255);
	}
}