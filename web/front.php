<?php

require_once __DIR__ . '/../src/autoload.php';

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

$request = Request::createFromGlobals();

$map = array(
	'/hello' => 'hello',
	'/bye' => 'bye',
);

$path = $request->getPathInfo();
if (isset($map[$path])) {
	ob_start();
	extract($request->query->all(), EXTR_SKIP);
	include sprintf(__DIR__ . '/../src/pages/%s.php', $map[$path]);
	$response = new Response(ob_get_clean());
} else {
	$response = new Response('Not found', 404);
}

$response->send();