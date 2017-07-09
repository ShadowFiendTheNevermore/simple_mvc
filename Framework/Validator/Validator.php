<?php 

namespace ShadowFiend\Framework\Validator;

use ShadowFiend\Framework\Application\DB;
use ShadowFiend\Framework\Config\Config;
use ShadowFiend\Framework\Validator\Rule;

/**
* 
*/
class Validator
{
	
	protected $errors = [];


	/**
	 * Validate input value with rules
	 * 
	 * @param  mixed $input
	 * @param  array $inputRule
	 * @return void
	 */
	public function __construct($input, array $inputRule) {
		if (is_array($input)) {
			$this->validateArray($input, $inputRule);
		}
	}


	public function getErrors()
	{
		return $this->errors;
	}

	// public function getErrors()
	// {
	// 	return $this->errors;
	// }


	
	public static function make($input, array $inputRule)
	{
		$self = new static($input, $inputRule);

		return $self;
	}



	/**
	 * Validate array using arrays for input and rules
	 * 
	 * @param  array  $inputArray
	 * @param  array  $arrayRules
	 * @return void
	 */
	public function validateArray(array $inputArray, array $arrayRules)
	{
		

		$checkFields = $this->makeCheckFields($arrayRules);

		foreach ($arrayRules as $ruleKey => $ruleValue) {
			if (array_key_exists($ruleKey, $inputArray)) {
				
				$rulesForValidation = $checkFields[$ruleKey]['rules'];

				if (array_key_exists('params', $checkFields[$ruleKey])) {
					$paramsForValidation = $checkFields[$ruleKey]['params'];
				} else {
					$paramsForValidation = [];
				}
				
				$inputArg = [$ruleKey => $inputArray[$ruleKey]];

				$this->validateArg($inputArg, $rulesForValidation, $paramsForValidation);
				
			}
			
		}
	}


	private function makeCheckFields($rules)
	{

		$fields = [];

		foreach ($rules as $ruleKey => $ruleValue) {

			$rulesArr = explode('|', $ruleValue);

			foreach ($rulesArr as $key => $value) {

				if (strpos($value, ':')) {

					$segments = explode(':', $value);

					$ruleName = array_shift($segments);

					$rulesArr[$key] = $ruleName;

					$fields[$ruleKey]['params'][$ruleName] = $segments;
				}
				$fields[$ruleKey]['rules'] = $rulesArr;
			}

		}

		return $fields;
	}


	private function validateArg($input, $rules, $params)
	{
		foreach ($rules as $rule) {
			$checkMethod = 'checkOn'.ucfirst($rule);
			$inputKey = array_keys($input)[0];
			$inputValue = array_values($input)[0];
			// var_dump($inputKey, $inputValue, $checkMethod);
			$this->{$checkMethod}($inputKey, $inputValue, $params);
		}
	}


	/**
	 * If Validator errors[] not empty return true else false;
	 * 
	 * @return boolean
	 */
	public function hasErrors()
	{
		if (!empty($this->errors)) {
			return true;
		} else {
			return false;
		}
	}


	/**
	 * All methods below (like checkOn<type>) checks on empty|email|string|integer|bolean value and set the Error in array with errors
	 * 
	 * @param  string $key
	 * @param  mixed $value
	 * @return
	 */
	private function checkOnRequired($key, $value, $params)
	{
		// var_dump($value);
		if (is_array($value)){

			if (! $this->isFormFile($value)) {
				$this->errors[] = "Image for form doesn't exists";
			}
		}

		if (empty($value))
			$this->errors[] = "$key can't be empty";
	}


	private function checkOnString($key, $value, $params)
	{
		if(!is_string($value))
			$this->errors[] = "$key must be a string";
	}

	private function checkOnInt($key, $value, $params)
	{
		if(!is_int($value))
			$this->errors[] = "$key must be a int";
	}


	private function checkOnBoolean($key, $value, $params)
	{
		if(!is_bool($value))
			$this->errors[] = "$key must be a boolean";
	}

	private function checkOnEmail($key, $value, $params)
	{
		$email = filter_var($value, FILTER_SANITIZE_EMAIL);
		if ($email && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
			$this->errors[] = "$key must be a valid email address";
		}
	}

	private function checkOnUnique($key, $value, $params)
	{

		if (array_key_exists('unique', $params)) {
			$param = $params['unique'][0];
		} else {
			throw new \Exception("Error in Validation for unique fields should be set param with table");
		}

		$db = DB::getConnection();

		$sth = $db->prepare("SELECT $key FROM $param WHERE login = :login");

		$sth->execute([':login' => $value]);

		$user = $sth->fetch();

		if (!empty($user)) {
			$this->errors[] = "$key with $value already exists";
		}

	}

	private function checkOnFile($key, $value, $params)
	{
		$allowedTypes = Config::getValue('validation.allowed.images');

		$fileType = array_search($value['type'], $allowedTypes);

		if ($fileType && !array_key_exists($fileType, $allowedTypes)) {
			$this->errors[] = "file with extension $fileType is not allowed";
		}

	}


	/**
	 * Returns true or false if array from form is not a valid array for a file
	 * 
	 * @param  array   $value
	 * @return boolean
	 */
	private function isFormFile(array $value)
	{
		if ($value['size'] !== 0 && $value['type'] !== '' && $value['tmp_name'] !== '') {
			return true;
		}else {
			return false;
		}
	}


}


