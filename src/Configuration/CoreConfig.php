<?php

namespace Ixa\WordPress\Configuration;

use Ixa\WordPress\Configuration\Exceptions\FileNotFoundException;

use Symfony\Component\Yaml\Parser;


class CoreConfig extends AbstractConfigLoader{

	const EXT = '.php';
	const DEFAULT_FILE_NAME = 'config';


	/**
	 * Load
	 * Parse and save file into $this->params
	 * @return void
	 */
	function load(){
		$path = $this->getFilePath();

		if(! file_exists($path)){
			throw new FileNotFoundException('Core Config', $path);
		}

		$config = include $path;

		$this->setParams($config);
	}


	/**
	 * Save
	 * Register all params as constants
	 * @return void
	 */
	function save(){

	}


	function getFileName(){
		$name = ($this->fileName) ? $this->fileName : self::DEFAULT_FILE_NAME;
		return $name . self::EXT;
	}


	function setParams(array $params){
		$this->params = $params;
	}


}