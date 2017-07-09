<?php 
namespace ShadowFiend\Framework\Router;

use ShadowFiend\Framework\Config\Config;
use ShadowFiend\Framework\Router\Route;
use ShadowFiend\Framework\Traits\BindApplication;

/**
* Main router class
*/
class Router
{

	use BindApplication;
	
	/**
	 * Array of all existed routes
	 * 
	 * @var array
	 */
	private $routes;
	

	/**
	 * Request method
	 * 
	 * @var string
	 */
	private $http_method;

	/**
	 * Current uri
	 * 
	 * @var string
	 */
	private $uri;


	/**
	 * Set default settings for Router 
	 */
	public function __construct()
	{
		$this->host = $_SERVER['SERVER_NAME'];
		$this->http_method = $_SERVER['REQUEST_METHOD'];
		$this->uri = $this->getURI();

	}

	/**
	 * This method run the route via the Application class
	 * TODO: Make default "/" router
	 * @return route->action()
	 */
	public function run()
	{

		foreach ($this->routes as $route) {
			if ($route->checkEquals($this->uri) && $route->checkRequestMethod($this->http_method)) {
				return $this->runRoute($route);
			}
		}
	}


	public function throwBadPage()
	{
		throw new \Exception("This page doesnt exists");
	}


	/**
	 * Call route action with parameters
	 * TODO: Try Catch BadMethodCallException
	 * @param  ShadowFiend\Framework\Router\Route $route
	 * @return callback;
	 */
	protected function runRoute($route)
	{

		if (is_array($route->action)) {

			$controller = new $route->action['controller'];
			$controllerAction = $route->action['controller_method'];
			
			call_user_func_array([$controller, $controllerAction], $route->params);

		} else {
			// Run callback
			call_user_func_array($route->action, $route->params);
		}

	}


	/**
	 * Add route to routes in Router
	 * 
	 * @param $routeOptions passed option for create new Route;
	 */
	public function addRoute($routeOptions)
	{
		
		$route = new Route();

		$routeAction = $this->makeRouteAction($routeOptions['action']);

		$route->setUri($routeOptions['uri'])
			  ->setAction($routeAction);


		if (array_key_exists('method', $routeOptions)) {
			$route->setMethod($routeOptions['method']);
		}


		$this->routes[] = $route;

	}

	/**
	 * Return route action as array or callable
	 * 
	 * @param  mixed $action
	 * @return mixed
	 */
	private function makeRouteAction($action)
	{
		
		if (is_callable($action)) {

			return $action;

		}elseif (is_string($action)) {

			return $this->getControllerForRoute($action);

		}

		throw new \Exception("Bad Action '$action' for route");

	}


	/**
	 * Return array with callable Class\Method
	 * 
	 * @param  string $controllerAction
	 * @return array                   
	 */
	private function getControllerForRoute(string $controllerAction)
	{
		$namespace = Config::getValue('app.controller_namespace');

		$controller = $namespace .'\\'. $this->getControllerNameFromSegments($controllerAction);

		$controllerMethod = $this->getControllerMethodFromSegments($controllerAction);

		return ['controller' => $controller, 'controller_method' => $controllerMethod];
	}


	/**
	 * Return controller name
	 * 
	 * @param  string $action
	 * @return string
	 */
	private function getControllerNameFromSegments($action)
	{
		return $this->getSegmentsFromActionString($action)[0];
	}


	/**
	 * Returns controller method
	 * 
	 * @param $controller
	 * @return string
	 */
	private function getControllerMethodFromSegments($segments)
	{
		return (string) strtolower($this->getSegmentsFromActionString($segments)[1]);
	}


	/**
	 * Splice Controller name and controller method
	 * 
	 * @param  string $action
	 * @return array
	 */
	private function getSegmentsFromActionString($action)
	{
		return explode('_', $action);
	}


	/**
	 * Returns request uri
	 * 
	 * @return string
	 */
	private function getURI()
	{
		if (! empty($_SERVER['REQUEST_URI']) && $_SERVER['REQUEST_URI'] !== '/') {
			return rtrim($_SERVER['REQUEST_URI'], '/');
		}

		return $_SERVER['REQUEST_URI'];
		
	}

}
