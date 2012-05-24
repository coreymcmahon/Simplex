<?php 

use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel;

class LeapYearController {
	private function _isLeapYear($year = null)
	{
		if (null === $year) {
			$year = date('Y');
		}
	
		return 0 == $year % 400 || (0 == $year % 4 && 0 != $year % 100);
	}
	
	public function indexAction($year)
	{
		if ($this->_isLeapYear($year)) {
			return new Response('Yes, this is a leap year!');
		}
		return new Response('No, not a leap year.');
	}
}

$routes = new RouteCollection();
$routes->add('leap_year', new Route(
	'/is_leap_year/{year}', 
	array('year' => null, '_controller' => 'LeapYearController::indexAction'))
);

return $routes;