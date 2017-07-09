<?php 
namespace ShadowFiend\Framework\Application;

use ShadowFiend\Framework\Config\Config;
use ShadowFiend\Framework\Router\Route;
use ShadowFiend\Framework\Router\Router;



/**
* Main application class
*/
class Application
{


	/**
	 * Description
	 * 
	 * @var [type]
	 */
	protected $router;

	/**
	 * Description
	 * 
	 * @var array
	 */
	protected $routes = [];

	/**
	 * Description
	 * 
	 * @var array
	 */
	protected $configs = [];
	/**
	 * Description
	 * 
	 * @var [type]
	 */
	public $applicationPath;


	/**
	 * Set the application path via __constructor
	 * 
	 * @param string $path
	 */
	public function __construct($path)
	{
		$this->applicationPath = realpath($path);

		$configPath = realpath($this->applicationPath . '/Configs');

		Config::init($configPath);
	}


	/**
	 * Set router for application globaly
	 * 
	 * @param $router
	 */
	public function setRouter(Router $router)
	{
		$this->router = $router;

		$this->router->setApplication($this);
	}


	/**
	 * Return the app path
	 * 
	 * @return string
	 */
	public function getAppPath()
	{
		return realpath($this->applicationPath);
	}

	/**
	 * Start the application lyfecircle
	 * 
	 * @see  \ShadowFiend\Framework\Router\Router
	 * @return void
	 */
	public function run()
	{
		$this->router->run($this->routes);
	}


	/**
	 * This method handle a get request
	 * 
	 * @param  string $uri
	 * @param  string|callable $action
	 * 
	 * @return void
	 */
	public function get($uri, $action)
	{
		$this->addRoute([
			'action' => $action,
			'uri'    => $uri
		]);
	}


	/**
	 * This method handle a post request
	 * 
	 * @param  string $uri
	 * @param  string|callable $action
	 * 
	 * @return void
	 */
	public function post($uri, $action)
	{
		$this->addRoute([
			'action' => $action,
			'uri'    => $uri,
			'method' => 'POST'
		]);
	}


	/**
	 * Add route to router
	 * 
	 * @param array $args
	 */
	private function addRoute(array $args)
	{
		$this->router->addRoute($args);
	}

}

