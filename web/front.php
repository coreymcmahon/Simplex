<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing;
use Symfony\Component\HttpKernel;
use Symfony\Component\EventDispatcher\EventDispatcher;


/* Create the request object and define the routes */
$request = Request::createFromGlobals();
$routes = include __DIR__ . '/../src/app.php';

$context = new Routing\RequestContext();
$context->fromRequest($request);
$matcher = new Routing\Matcher\UrlMatcher($routes, $context);
$resolver = new HttpKernel\Controller\ControllerResolver();


/* Register event handlers */
$dispatcher = new EventDispatcher();
$dispatcher->addSubscriber(new Simplex\GoogleListener());
$dispatcher->addSubscriber(new Simplex\ContentLengthListener());


/* Set-up the framework and handle the request */
$framework = new Simplex\Framework($dispatcher, $matcher, $resolver);
$framework = new HttpKernel\HttpCache\HttpCache($framework, new HttpKernel\HttpCache\Store(__DIR__.'/../cache'));

$response = $framework->handle($request);

$response->send();