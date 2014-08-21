<?php

namespace Ixa\WordPress\Configuration;


abstract class AbstractConfigLoader implements ConfigLoader{

	protected $dir;
	protected $fileName;
	protected $environment;

	protected $params;

	public function __construct($dir, $filename = null, $environment = null){
		$this->setDir($dir);
		$this->setFileName($filename);
		$this->setEnvironment($environment);
		$this->params = array();
	}


	/**
	 * Load
	 * Parse and save file into $this->params
	 * @return void
	 */
	function load(){
		// In order to make compliant with ConfigLoader interface
		// $filename params is set to null, but if its not given
		// an InvalidArgumentException is thrown
		if(! $this->fileName){
			$msg = ' requires a filename to load config, '
					. 'you can provide one either by the constructor (2nd argument)'
					. 'or `setFileName()` method.';

			throw new \LogicException(__CLASS__ . $msg);
		}


		$this->loadFile($this->getFileName());
		$this->loadFile($this->getEnvironmentFilePath(), false);

		// Return params
		return new Repository($this->params);
	}


	abstract protected function loadFile($path, $strict = false);
	
	abstract public function getExt();
	
	/**
	 * Save
	 * Register all params as constants
	 * @deprecated
	 * @return void
	 */
	function save(){
		// Configuration should not be saved
		trigger_error("Save method is deprecated in " . __CLASS__, E_WARNING);
	}

	function getDir(){
		return $this->dir;
	}

	function getParams(){
		return $this->params;
	}

	function addToParams(array $params){
		$this->params = array_merge($this->params, $params);
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


	function getFileName(){
		return $this->fileName . $this->getExt();
	}

	function getEnvironmentFilePath(){
		if($this->environment){
			return $this->fileName . '.' . $this->environment . $this->getExt();
		}
	}
}