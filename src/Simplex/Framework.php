<?php 

namespace Simplex;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing;
use Symfony\Component\HttpKernel;

class Framework {
	protected $_matcher;
	protected $_resolver;
	
	public function __construct(Routing\Matcher\UrlMatcherInterface $matcher, HttpKernel\Controller\ControllerResolverInterface $resolver)
	{
		$this->_matcher = $matcher;
		$this->_resolver = $resolver;
	}
	
	public function handle(Request $request)
	{
		try {
			$request->attributes->add($this->_matcher->match($request->getPathInfo()));
			
			$controller = $this->_resolver->getController($request);
			$arguments = $this->_resolver->getArguments($request, $controller);
			
			return call_user_func_array($controller, $arguments);
		} catch (Routing\Exception\ResourceNotFoundException $e) {
			return new Response('Not found', 404);
		} catch (\Exception $e) {
			return new Response('An error occurred', 500);
		}
	}
}