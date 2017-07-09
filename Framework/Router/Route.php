<?php 
namespace ShadowFiend\Framework\Router;

use ShadowFiend\Framework\Controller\Controller;



/**
 * 
 */
class Route
{


	/**
	 * Action of route
	 * 
	 * @var mixed
	 */
	public $action;

	/**
	 * Method of request
	 * 
	 * @var string
	 */
	public $method;

	/**
	 * String with parameters and path to.
	 * 
	 * @var string
	 */
	public $uri;

	/**
	 * Parameters setted by regular expression in uri string
	 * 
	 * @var $params
	 */
	public $params = [];

	/**
	 * Brackets(borders) for route params
	 * 
	 * @var array
	 */
	private $uriParamsBrackets = ['{', '}'];

	/**
	 * Main Pattern for searching
	 * 
	 * @var string
	 */
	private $patternUri;


	public function __construct($method = null)
	{
		isset($method) ? $this->method = $method : $this->method = 'GET';
	}

	/**
	 * Set the method for Route
	 * 
	 * @param string $method GET|POST|TODO
	 * @return  $this|Route
	 */
	public function setMethod(string $method)
	{
		$this->method = $method;

		return $this;
	}


	/**
	 * Set the action for Route
	 * 
	 * @param callable|string $action
	 * @return  $this
	 */
	public function setAction($action)
	{
		$this->action = $action;

		return $this;
	}

	/**
	 * Set uri for Route
	 * 
	 * @param   string $url
	 * @return  $this
	 */
	public function setUri(string $uri)
	{
		$this->uri = $uri === '/' ? $uri : rtrim($uri, '/');

		$this->patternUri = $this->makePatternUri();

		return $this;
	}


	/**
	 * Make regular expression for $patternUri
	 *
	 * @return string|RegEx;
	 */
	private function makePatternUri()
	{
		$patternUri = preg_replace($this->makeBracketsPattern('\w+'), '(\w+)', $this->uri);

		return sprintf('~^%s$~', $patternUri);
	}


	/**
	 * check Equals passed uri with Route pattern uri
	 * 
	 * @param  string $uri
	 * @return boolean
	 */
	public function checkEquals($uri)
	{
		if (preg_match($this->patternUri, $uri)) {
			$this->params = $this->getUriParams($uri);

			return true;
		} else {
			return false;
		}
	}



	/**
	 * Returns all params in uri | {something} e.t.c
	 * 
	 * @param  string $uri
	 * @return array
	 */
	private function getUriParams($uri)
	{
		preg_match($this->patternUri, $uri, $matches);

		array_shift($matches);
		
		return $matches;
	}


	/**
	 * Make RegEx with $uriParamsBrackets and innerPattern
	 * 
	 * @param  string $innerPattern 
	 * @return string|RegEx
	 */
	private function makeBracketsPattern($innerPattern)
	{
		return sprintf('~\%s(%s)\%s~', $this->uriParamsBrackets[0], $innerPattern, $this->uriParamsBrackets[1]);	
	}

	/**
	 * Check if route method equals $method
	 * 
	 * @param  string $method Request method POST|GET
	 * @return boolean
	 */
	public function checkRequestMethod($method)
	{
		return $this->method === $method ? true : false; 
	}


}


