<?php

namespace Ixa\WordPress\Configuration;


class EnvVarConfig{

	const EXT = '.yml';
	const DEFAULT_FILE_NAME = 'env';

	protected $dir;
	protected $fileName;

	protected $params;

	public function __construct($dir, $fileName = null){
		$this->setDir($dir);
		$this->setFileName($fileName);
	}


	function load(){

		$content = file_get_contents($this->getFilePath());

	}


	function getFilePath(){
		return $this->getDir() . $this->getFileName();
	}

	function getParams(){
		return $this->params;
	}


	function getFileName(){
		$name = ($this->fileName) ? $this->fileName : self::DEFAULT_FILE_NAME;
		return $name . self::EXT;
	}


	function getDir(){
		return $this->dir;
	}


	function setDir($dir){
		$this->dir = $dir;
	}

	function setFileName($fileName){
		$this->fileName = $fileName;
	}
}