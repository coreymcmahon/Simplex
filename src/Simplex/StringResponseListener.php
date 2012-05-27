<?php

namespace Simplex;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\GetResponseForControllerResultEvent;
use Symfony\Component\HttpFoundation\Response;

class StringResponseListener implements EventSubscriberInterface {

	public function onView(GetResponseForControllerResultEvent $event)
	{
		$response = $event->getControllerResult();

		if (is_string($response)) {
			$event->setResponse(new Response($response));
		}
	}

	static function getSubscribedEvents()
	{
		return array('kernel.view' => 'onView');
	}
}