<?php 

namespace Simplex;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing;
use Symfony\Component\HttpKernel;
use Symfony\Component\EventDispatcher;

class Framework implements HttpKernel\HttpKernelInterface {
	protected $_matcher;
	protected $_resolver;
	protected $_dispatcher;
	
	public function __construct(EventDispatcher\EventDispatcherInterface $dispatcher, Routing\Matcher\UrlMatcherInterface $matcher, HttpKernel\Controller\ControllerResolverInterface $resolver)
	{
		$this->_matcher = $matcher;
		$this->_resolver = $resolver;
        $this->_dispatcher = $dispatcher;
	}
	
	public function handle(Request $request, $type = self::MASTER_REQUEST, $catch = true)
	{
		try {
			$request->attributes->add($this->_matcher->match($request->getPathInfo()));

			$controller = $this->_resolver->getController($request);
			$arguments = $this->_resolver->getArguments($request, $controller);

			$response = call_user_func_array($controller, $arguments);
		} catch (Routing\Exception\ResourceNotFoundException $e) {
			$response = new Response('Not found', 404);
		} catch (\Exception $e) {
			$response = new Response('An error occurred', 500);
		}

		$this->_dispatcher->dispatch('response', new ResponseEvent($response, $request));
		return $response;
	}
}