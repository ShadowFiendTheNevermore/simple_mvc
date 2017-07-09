<?php 
namespace ShadowFiend\Framework\Controller;

use ShadowFiend\Framework\Config\Config;

/**
* Controller class
* TODO: Make Sessions handler or Request and Response class
*/
class Controller
{


	/**
	 * [post description]
	 * @param  string $key [description]
	 * @return [type]      [description]
	 */
	protected function post(string $key)
	{
		if (isset($_POST[$key])) {
			return $this->escapeVar($_POST[$key]);
		}
	}


	protected function getSession()
	{
		return $_SESSION;
	}


	/**
	 * [escapeVar description]
	 * @param  [type] $var [description]
	 * @return [type]      [description]
	 */
	protected function escapeVar(string $var)
	{
		return htmlspecialchars($var);
	}



	/**
	 * Returns all data from HTTP request
	 * 
	 * @return array
	 */
	protected function getAllRequestData()
	{
		return array_merge($_POST, $_GET, $_FILES);
	}


	/**
	 * Returns HTTP request data via request key
	 * 
	 * @param  string $requestType 'get|post|cookies'
	 * @return array
	 */
	protected function getRequestData(string $requestType)
	{

		$reqData = [];
		switch (strtolower($requestType)) {
			case 'get':
				$reqData = $_GET;
				break;
			case 'post':
				$reqData = $_POST;
				break;
			case 'cookies':
				$reqData = $_COOKIE;
				break;
		}

		foreach ($reqData as $key => $value) {
			$reqData[$key] = $this->escapeVar($value);
		}

		return $reqData;

	}



	protected function getRequestReferer()
	{
		return $_SERVER['HTTP_REFERER'];
	}


	protected function redirect($redirectUrl)
	{
		header("Location:".$redirectUrl);
	}





}

