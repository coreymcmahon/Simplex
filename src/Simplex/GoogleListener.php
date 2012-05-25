<?php

namespace Simplex;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class GoogleListener implements EventSubscriberInterface
{
	public function onResponse(ResponseEvent $event)
	{
		$response = $event->getResponse();

		if ($response->isRedirection() ||
			$response->headers->has('Content-Type') && false === strpos($response->headers->get('Content-Type'), 'html') ||
			'html' !== $event->getRequest()->getRequestFormat()
		) {
			return;
		}

		$response->setContent($response->getContent() . 'GA CODE');
	}

	public static function getSubscribedEvents()
	{
		return array('response' => 'onResponse');
	}
}
