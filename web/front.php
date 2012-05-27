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
$matcher = new Routing\Matcher\UrlMatcher($routes, $context);
$resolver = new HttpKernel\Controller\ControllerResolver();

/* Register event handler */
$dispatcher = new EventDispatcher();
$dispatcher->addSubscriber(new HttpKernel\EventListener\ExceptionListener('Calendar\\Controller\\ErrorController::exceptionAction'));
$dispatcher->addSubscriber(new HttpKernel\EventListener\ResponseListener('UTF-8'));
$dispatcher->addSubscriber(new HttpKernel\EventListener\StreamedResponseListener());
$dispatcher->addSubscriber(new Simplex\StringResponseListener());
$dispatcher->addSubscriber(new HttpKernel\EventListener\RouterListener($matcher));

/* Set-up the framework and handle the request */
$framework = new Simplex\Framework($dispatcher, $resolver);

$response = $framework->handle($request);
$response->send();