<?php

namespace Ixa\WordPress\Configuration;


abstract class AbstractConfigLoader implements ConfigLoader{

	protected $dir;
	protected $fileName;
	protected $environment;

	protected $params;

	public function __construct($dir, $filename = null, $environment = null){
		// In order to make compliant with ConfigLoader interface
		// $filename params is set to null, but if its not given
		// an InvalidArgumentException is thrown
		if(! $filename){
			throw new \InvalidArgumentException('Filename is required to create a ConfigLoader');
		}

		$this->setDir($dir);
		$this->setFileName($filename);
		$this->setEnvironment($environment);
		$this->params = array();
	}

	abstract public function load();
	
	/**
	 * Save
	 * Register all params as constants
	 * @return void
	 */
	function save(){
		foreach ($this->getParams() as $key => $value) {
			$constant = strtoupper($key);

			if(! defined($constant)) define($constant, $value);
		}
	}


	function getFilePath(){
		return $this->getDir() . $this->getFileName();
	}

	function getFileName(){
		return $this->fileName;
	}

	function getDir(){
		return $this->dir;
	}

	function getParams(){
		return $this->params;
	}

	function setParams(array $params){
		$this->params = $params;
	}

	protected function setDir($dir){
		$this->dir = $dir;
	}

	protected function setFileName($fileName){
		$this->fileName = $fileName;
	}

	protected function setEnvironment($environment){
		$this->environment = $environment;
	}

}