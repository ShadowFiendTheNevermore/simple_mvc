<?php 

namespace ShadowFiend\Framework\Validator;

use ShadowFiend\Framework\Validator\Validator;

/**
* 
*/
class Rule
{
	
	protected $params = [];

	protected $types = [];

	public function __construct(array $params = [])
	{
		$this->params = $params;
	}


	public function setTypes(array $types)
	{
		$this->types = $types;
	}


	public function checkValid($input, $inputRules)
	{
		foreach ($inputRules as $rule) {
			// $validatorMethod = 'checkOn' . $ruleValue;
			print_r($rule['rules']);
			// Validator::{$validatorMethod}($ruleKey, $ruleValue);
		}
	}


	
	
}



