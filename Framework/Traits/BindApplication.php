<?php 
namespace ShadowFiend\Framework\Traits;


trait BindApplication {

	protected $application;

	public function setApplication($application)
	{
		$this->application = $application;
	}

	public function getApplication()
	{
		return $this->application;
	}

}