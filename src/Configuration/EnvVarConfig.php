<?php

namespace Ixa\WordPress\Configuration;


class EnvVarConfig{

	const EXT = '.yml';
	const DEFAULT_FILE_NAME = 'env';

	protected $dir;
	protected $fileName;


	public function __construct($dir, $fileName = null){
		$this->setDir($dir);
		$this->setFileName($fileName);
	}


	function getFilePath(){
		$this->getDir() . $this->getName() . self::EXT;
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