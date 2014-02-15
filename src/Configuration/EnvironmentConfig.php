<?php

namespace Ixa\WordPress\Configuration;

use Ixa\WordPress\Configuration\Exceptions\FileNotFoundException;

use Symfony\Component\Yaml\Parser;


class EnvironmentConfig implements ConfigLoader{

	const EXT = '.yml';
	const DEFAULT_FILE_NAME = 'env';

	const PARAMS_KEY = 'parameters';

	static $validKeys = array(
		'environment',
		'db_user',
		'db_name',
		'db_host',
		'db_password',
		'wp_home'
	);

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

		$path = $this->getFilePath();

		if(! file_exists($path)){
			throw new FileNotFoundException('Environment', $path);
		}

		$content = file_get_contents($this->getFilePath());

		$this->setParams($this->parser->parse($content));
	}


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

	function getParams(){
		return $this->params;
	}


	function setParams(array $params){
		if(array_key_exists(self::PARAMS_KEY, $params) && is_array($params[self::PARAMS_KEY])){
			$this->params = array_intersect_key(
				$params[self::PARAMS_KEY], 
				array_flip(self::$validKeys)
			);
		}
	}


	function getFileName(){
		$name = ($this->fileName) ? $this->fileName : self::DEFAULT_FILE_NAME;
		return $name . self::EXT;
	}


	function getDir(){
		return $this->dir;
	}


	function setParser(Parser $parser){
		$this->parser = $parser;
	}

	protected function setDir($dir){
		$this->dir = $dir;
	}

	protected function setFileName($fileName){
		$this->fileName = $fileName;
	}
}