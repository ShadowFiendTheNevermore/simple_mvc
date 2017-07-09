<?php 
namespace ShadowFiend\Framework\View;

use ShadowFiend\Framework\Config\Config;

/**
* Main View class
*/
class View
{


	/**
	 * Path with view
	 * 
	 * @var string
	 */
	protected $viewsPath;


	/**
	 * Create new View with passed variables
	 * 
	 * @param string $viewName
	 */
	public function __construct(string $viewName, $variables = [])
	{
		$this->viewsPath = $this->getViewsPathFromConfig();

		$this->viewName = $viewName;

		$this->viewVariables = $variables;

		$this->render();

	}


	/**
	 * Return path to directory with views
	 * 
	 * @return string | path to views
	 */
	private function getViewsPathFromConfig()
	{
		return Config::getValue('app.view_path');
	}


	/**
	 * Makes a new view instance
	 * @param  string $viewName| name of view
	 * @param  array  $vars    | passed variables
	 * 
	 * @return new View($viewName, $vars);
	 */
	public static function make($viewName, $vars = [])
	{
		return new self($viewName, $vars);
	}


	public function render()
	{

		$view = $this->viewsPath .'/'.$this->viewName.'.view.php';

		if (!$this->viewVariables) {
			foreach ($this->viewVariables as $key => $value) {
				$$key = $value;
			}
		}

		!$this->viewVariables ?:extract($this->viewVariables, EXTR_SKIP);

		if(file_exists($view)){
			include $view;
		} else {
			throw new \Exception("Can't find view: '$view'");
		}

	}


}