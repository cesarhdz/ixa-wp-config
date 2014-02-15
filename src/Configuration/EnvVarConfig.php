<?php

namespace Ixa\WordPress\Configuration;

use Symfony\Component\Yaml\Parser;


class EnvVarConfig{

	const EXT = '.yml';
	const DEFAULT_FILE_NAME = 'env';

	const PARAMS_KEY = 'parameters';


	protected $dir;
	protected $fileName;

	protected $params;

	public function __construct($dir, $fileName = null){
		$this->setDir($dir);
		$this->setFileName($fileName);


		$this->params = array();
		$this->setParser(new Parser());
	}


	/**
	 * Load
	 * Parse and save file into $this->params
	 * @return void
	 */
	function load(){

		$content = file_get_contents($this->getFilePath());

		$this->setParams($this->parser->parse($content));
	}


	function save(){
		foreach ($this->getParams() as $key => $value) {
			define(strtoupper($key), $value);
		}
	}


	function getFilePath(){
		return $this->getDir() . $this->getFileName();
	}

	function getParams(){
		return $this->params;
	}


	function setParams(array $params){
		if(array_key_exists(self::PARAMS_KEY, $params) && is_array($params[self::PARAMS_KEY])){
			$this->params = $params[self::PARAMS_KEY];
		}
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


	function setParser(Parser $parser){
		$this->parser = $parser;
	}
}