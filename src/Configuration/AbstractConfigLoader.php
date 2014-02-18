<?php

namespace Ixa\WordPress\Configuration;


abstract class AbstractConfigLoader implements ConfigLoader{

	protected $dir;
	protected $fileName;

	protected $params;

	public function __construct($dir, $fileName = null){
		$this->setDir($dir);
		$this->setFileName($fileName);
		$this->params = array();
	}

	abstract public function load();
	
	abstract public function save();


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