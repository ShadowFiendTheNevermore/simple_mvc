<?php 

namespace ShadowFiend\Framework\Config;

use ShadowFiend\Framework\Traits\BindApplication;

/**
* Main Config class 
* Позволяет использовать файлы конфигурации в классе Application
* 
*/
class Config
{

	protected static $configs = [];

	protected static $configPath;


	/**
	 * Set the path to directory with configs
	 * 
	 * @param string $configPath
	 */
	public static function init($path)
	{
		static::$configPath = realpath($path);

		static::addConfigsFromDir(static::$configPath);
	}


	/**
	 * Add config
	 * 
	 * @param string $file | path to config in configPath
	 * @param string $name | key for config
	 */
	public static function addConfig(string $file, $name = null)
	{
		$config = static::$configPath.'/'.$file;

		if (file_exists($config)) {
			static::$configs[strstr($file, '.', true)] = require($config);
		}

	}

	/**
	 * return all configs
	 * @return array array with configs
	 */
	public static function getConfigs()
	{
		return static::$configs;
	}

	/**
	 * Add configs from folder
	 * Call the Config->addConfig() for each file in directory.
	 * 
	 * @param string $dir | path to directory
	 */
	public static function addConfigsFromDir($dir)
	{
		$file_list = array_diff(scandir($dir), ['.', '..']);

		foreach ($file_list as $file) {
			static::addConfig($file);
		}
	}

	/**
	 * Return the value passed by key string
	 * @param  string $key string with . seperators
	 * @return mixed
	 */
	public static function getValue(string $key)
	{
		return self::getConfigValuesFromQuery(static::$configs, $key);
	}


	/**
	 * Return needed values from config
	 * 
	 * @param array $array | array which contains configs values
	 * @param  string $key | string like as 'main.application_name'
	 * 
	 * @return array
	 */
	private static function getConfigValuesFromQuery(array $array, string $key)
	{
		
		foreach (explode('.', $key) as $segment) {
			$array = $array[$segment];
		}

		return $array;
	}


}
