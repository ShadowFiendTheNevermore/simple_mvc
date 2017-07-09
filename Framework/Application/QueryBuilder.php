<?php 

namespace ShadowFiend\Framework\Application;

use ShadowFiend\Framework\Application\DB;
use ShadowFiend\Framework\Config\Config;
use ShadowFiend\Framework\Model\Model;


class QueryBuilder
{

	private $db;
	
	private $model;

	private $arguments = [];

	/**
	 * Set the model to query builder instance and set DB connect
	 * 
	 * @param Model|null $model [description]
	 */
	public function __construct(Model $model = null)
	{
		$this->db = DB::getConnection();
		$this->model = $model;
	}

	public function getArguments()
	{
		return $this->arguments;
	}


	/**
	 * Returns all data from table
	 * 
	 * @see QueryBuilder->getAllFromTable();
	 * @return array
	 */
	public function all()
	{
		return $this->getAllFromTable($this->model->getTableName());
	}



	/**
	 * Returns all data from table
	 * 
	 * @param  string $table table name
	 * @return array
	 */
	private function getAllFromTable($table)
	{
		
		$sth = $this->db->prepare("SELECT * FROM $table");
		
		$sth->execute();

		$data = $sth->fetchAll();

		return $data;
		
	}


	/**
	 * Inserts data to table
	 * 
	 * @param  string $table table name
	 * @param  array $data  array with binds and values
	 * @return void
	 */
	public function insertIntoTable($data)
	{

		foreach ($data as $insert) {

			$fields = array_keys($insert);
			$values = array_values($insert);

			$dbFields = $this->makeDbFields($fields);
			$binds = $this->makeBindsFromFields($fields);

			$table = $this->model->getTableName();

			$sth = $this->db->prepare("INSERT INTO $table ($dbFields) VALUES ( $binds )");

			$sth->execute($this->makeExecuteArr($binds, $values));

		}

	}


	private function makeDbFields($fields)
	{
		return implode(',', $fields);
	}

	/**
	 * Makes bind from array with fields in database
	 * 
	 * @param  array $fields
	 * @return string
	 */
	private function makeBindsFromFields($fields)
	{
		return ':'.implode(',:', $fields);
	}


	/**
	 * Makes array from $binds and array with values
	 * 
	 * @param  string $binds example: $binds after makeBindsFromFields
	 * @param  array $values
	 * @return array
	 */
	private function makeExecuteArr($binds, $values)
	{
		return array_combine(explode(',', $binds), $values);
	}


	public function setModel($model)
	{
		$this->model = $model;
	}


	public function saveFromModel()
	{
		$data = [$this->model->getFields()];

		$this->insert($data);

	}


	public function getUserAuthFields()
	{

		$usersTable = Config::getValue('db.users_table');

		$sth = $this->db->prepare('SELECT * FROM users');

		$sth->execute();

		$data = $sth->fetchAll();

		return $data;

	}


	/**
	 * Insert data to Model table
	 * 
	 * @param  Model  $model
	 * @return void
	 */
	public function insert($data){
		return $this->insertIntoTable($data);
	}

	public function where($whereClause)
	{
		$table = $this->model->getTableName();

		$sth = $this->db->prepare("SELECT * FROM $table WHERE :whereClause");

		// TODO: make multiply whereClauses
		$sth->execute([':whereClause' => $whereClause]);

		$data = $sth->fetchAll();

		return $data;
	}


	/**
	 * Update a model columns values
	 * 
	 * @param  array  $updateArr
	 * @param  string $whereClause
	 * @return int | updated rows
	 */
	public function update(array $updateArr, $whereClause)
	{
		return $this->updateWhere($updateArr, $whereClause);
	}


	/**
	 * Update with where clause
	 * 
	 * @param  array  $updateArr
	 * @param  string|array $whereClause
	 * @return int              Count of update rows;
	 */
	public function updateWhere(array $updateArr, $whereClause)
	{
		$table = $this->model->getTableName();

		$updateKeys = array_keys($updateArr);

		$updateValues = array_values($updateArr);

		$updateFields = $this->makeUpdateFields($updateArr);

		$whereBinds = $this->makeWhereBinds($whereClause);

		$sth = $this->db->prepare("UPDATE $table SET $updateFields WHERE $whereClause");

		$execArr = $this->makeExecuteArr($this->makeBindsFromFields($updateKeys), $updateValues);

		$sth->execute($execArr);

		$rows = $sth->rowCount();

		return $rows;

	}


	/**
	 * [makeWhereClauseBinds description]
	 * @param  [type] $whereClause [description]
	 * @return [type]              [description]
	 */
	public function makeWhereBinds($whereArr)
	{
		sd($whereArr);
	}


	/**
	 * Returns string of fields for update sql query
	 * 
	 * @param  array $updateArr
	 * @return string
	 */
	private function makeUpdateFields(array $updateArr)
	{
		$fields = [];

		$keys = array_keys($updateArr);

		foreach ($keys as $key) {
			$fields[] = $key . ' = ' . ':' . $key;
		}

		return implode(',', $fields);

	}



	/**
	 * Returns whereClause for sql query
	 * 
	 * @param  mixed $whereClause
	 * @return mixed
	 */
	private function makeWhereClause($whereClause)
	{
		if (is_array($whereClause)) {
			return $this->makeWhereClauseFromArray($whereClause);
		}

		return $whereClause;
	}

	/**
	 * Returns string of ready for execute WhereClauses for SQL query
	 * TODO: Make different type of WHERE operators AND|OR|AND($val OR $val);
	 * 
	 * @param  array  $whereArr
	 * @return string
	 */
	private function makeWhereClauseFromArray(array $whereArr)
	{

		$whereClauses = [];
		foreach ($whereArr as $key => $value) {
			$whereClauses[] = sprintf('%s %s %s', $key, $value['where_type'], $value['where_value']) ;
		}

		return implode(' AND ', $whereClauses);
	}



}
