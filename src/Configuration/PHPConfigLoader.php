<?php

namespace Ixa\WordPress\Configuration;

use Ixa\WordPress\Configuration\Exceptions\FileNotFoundException;
use Ixa\WordPress\Configuration\Exceptions\InvalidConfigException;

use Symfony\Component\Yaml\Parser;


class PHPConfigLoader extends AbstractConfigLoader{

	const EXT = 'php';


	function supports($name){
		return $name === self::EXT;
	}

	function getExt(){
		return '.' . self::EXT;
	}

	
	protected function parseFile($file){
		$config = include $file;

		if(! is_array($config)){
			throw new InvalidConfigException("The config file must return an instance of Array", $file);
		}
		
		return $config;	
	}
	
}