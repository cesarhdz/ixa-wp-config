<?php

namespace Ixa\WordPress\Configuration;

use Ixa\WordPress\Configuration\Exceptions\FileNotFoundException;
use Ixa\WordPress\Configuration\Exceptions\InvalidConfigException;

use Symfony\Component\Yaml\Parser;


class PHPConfigLoader extends AbstractConfigLoader{

	const EXT = 'php';


	function getExt(){
		return '.' . self::EXT;
	}

	/**
	 * Load
	 * Parse and save file into $this->params
	 * @return void
	 */
	function load(){
		$this->loadFile($this->getFileName());
		$this->loadFile($this->getEnvironmentFilePath(), false);

		// Return params
		return new Repository($this->getParams());
	}


	protected function loadFile($path, $strict = true){

		// Path should be absolute
		if($path){
			$path = $this->dir . $path;
		}

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
}