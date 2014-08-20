<?php

namespace Ixa\WordPress\Configuration;

use Ixa\WordPress\Configuration\Exceptions\FileNotFoundException;
use Ixa\WordPress\Configuration\Exceptions\InvalidConfigException;

use Symfony\Component\Yaml\Parser;


class PHPConfigLoader extends AbstractConfigLoader{

	const EXT = '.php';


	/**
	 * Load
	 * Parse and save file into $this->params
	 * @return void
	 */
	function load(){
		$this->loadFile($this->getFilePath());
		$this->loadFile($this->getEnvironmentFilePath(), false);

		// Return params
		return $this->getParams();
	}



	protected function loadFile($path, $strict = true){
		if(! file_exists($path)){
			if($strict) throw new FileNotFoundException('Core Config', $path);
			return;
		}

		$config = include $path;

		if(! is_array($config)){
			throw new InvalidConfigException("The config file must return an instance of Array", $path);
		}
		
		$this->addToParams($config);
	}


	function getFileName($suffix = ''){
		return $this->fileName . $suffix . self::EXT;
	}


	function addToParams(array $params){
		$this->params = array_merge($this->params, $params);
	}


	function getEnvironmentFilePath(){
		if($this->environment){
			return 	$this->getDir() . $this->getFileName('.' . $this->environment);
		}
	}

}