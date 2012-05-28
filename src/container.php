<?php

use Symfony\Component\DependencyInjection;
use Symfony\Component\DependencyInjection\Reference;

$sc = new DependencyInjection\ContainerBuilder();
$sc->register('context', 'Symfony\Component\Routing\RequestContext');
$sc->register('matcher', 'Symfony\Component\Routing\Matcher\UrlMatcher')
	->setArguments(array('%routes%', new Reference('context')))
;
$sc->register('resolver', 'Symfony\Component\HttpKernel\Controller\ControllerResolver');

$sc->register('listener.router', 'Symfony\Component\HttpKernel\EventListener\RouterListener')
	->setArguments(array(new Reference('matcher')))
;
$sc->register('listener.response', 'Symfony\Component\HttpKernel\EventListener\ResponseListener')
	->setArguments(array('%charset%'))
;
$sc->register('listener.exception', 'Symfony\Component\HttpKernel\EventListener\ExceptionListener')
	->setArguments(array('Calendar\\Controller\\ErrorController::exceptionAction'))
;
$sc->register('dispatcher', 'Symfony\Component\EventDispatcher\EventDispatcher')
	->addMethodCall('addSubscriber', array(new Reference('listener.router')))
	->addMethodCall('addSubscriber', array(new Reference('listener.response')))
	->addMethodCall('addSubscriber', array(new Reference('listener.exception')))
;
$sc->register('framework', 'Simplex\Framework')
	->setArguments(array(new Reference('dispatcher'), new Reference('resolver')))
;
return $sc;