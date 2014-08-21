<?php

namespace Ixa\WordPress\Configuration;

// @deprecated
abstract class ConstantsConfig implements ConfigLoader{

	protected $dir;
	protected $fileName;

	protected $params;

	public function __construct($dir, $fileName = null){
		$this->setDir($dir);
		$this->setFileName($fileName);
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

}