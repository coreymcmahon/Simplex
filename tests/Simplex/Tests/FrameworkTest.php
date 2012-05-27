<?php 

namespace Simplex\Tests;

use Simplex\Framework;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\HttpKernel;

class FrameworkTest extends \PHPUnit_Framework_TestCase
{
	public function testNotFoundHandling()
	{
		$framework = $this->getFrameworkForException(new ResourceNotFoundException());
		$response = $framework->handle(new Request());
		$this->assertEquals(404, $response->getStatusCode());
	} 
	
	protected function getFrameworkForException($exception)
	{
		$dispatcher = $this->getMock('Symfony\Component\EventDispatcher\EventDispatcherInterface');

		$matcher = $this->getMock('Symfony\Component\Routing\Matcher\UrlMatcherInterface');
		$matcher
			->expects($this->once())
			->method('match')
			->will($this->throwException($exception))
		;
		$resolver = $this->getMock('Symfony\Component\HttpKernel\Controller\ControllerResolverInterface');
		
		return new Framework($dispatcher, $resolver);
	}
	
	public function testControllerResponse()
	{
		$dispatcher = $this->getMock('Symfony\Component\EventDispatcher\EventDispatcherInterface');

		$matcher = $this->getMock('Symfony\Component\Routing\Matcher\UrlMatcherInterface');
		$matcher
			->expects($this->once())
			->method('match')
			->will($this->returnValue(array(
				'_route' => 'foo',
				'name' => 'Fabien',
				'_controller' => function ($name) {
					return new Response('Hello ' . $name);
				}
			)))
		;
		$resolver = new HttpKernel\Controller\ControllerResolver();

		$framework = new Framework($dispatcher, $resolver);
		
		$response = $framework->handle(new Request());
		
		$this->assertEquals(200, $response->getStatusCode());
		$this->assertContains('Hello Fabien', $response->getContent());
	}
}