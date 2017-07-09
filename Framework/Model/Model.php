<?php 
namespace ShadowFiend\Framework\Model;

use ShadowFiend\Framework\Application\DB;
use ShadowFiend\Framework\Application\QueryBuilder;
use ShadowFiend\Framework\Config\Config;

abstract class Model
{

	/**
	 * DB table name
	 * 
	 * @var string
	 */
	protected $table_name;

	/**
	 * Fields passed via magic method
	 * 
	 * @var array
	 */
	protected $fields = [];


	/**
	 * Need for create new model instance
	 * Allow only insert in DB new value
	 */
	public function __construct()
	{
		if (! isset($this->table_name))
			throw new \Exception("Model can't be used without field table_name");

		return $this;
	}



	/**
	 * Magic method for set fields for model
	 * @param string $name
	 * @param mixed $value
	 */
	public function __set($name, $value)
	{
		$this->fields[$name] = $value;
	}


	/**
	 * Return new QueryBuilder from Model
	 * 
	 * @param  string $method method of Class example: NameModel::method
	 * @param  array|null $args   passed arguments for method
	 * 
	 * @return mixed
	 */
	public static function __callStatic($method, $args = null)
	{
		$model = new static();
		$qb = new QueryBuilder($model);


		// TODO: make optimization for first of 4 elements to object
		return call_user_func_array([$qb, $method], $args);
		
		throw new \BadMethodCallException("Can't call DB::{$method}");
	}


	/**
	 * Make insert data to DB
	 * 
	 * @return void
	 */
	public function save()
	{
		$qb = new QueryBuilder();

		$qb->setModel($this);

		$qb->saveFromModel();
	}


	/**
	 * Returns table_name from Model
	 * 
	 * @return string
	 */
	public function getTableName()
	{
		return $this->table_name;
	}


	/**
	 * Returns all fields
	 * 
	 * @return array
	 */
	public function getFields()
	{
		return $this->fields;
	}



}