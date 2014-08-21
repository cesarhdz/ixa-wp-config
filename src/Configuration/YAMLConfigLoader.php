<?php

namespace Ixa\WordPress\Configuration;

use Ixa\WordPress\Configuration\Exceptions\FileNotFoundException;
use Ixa\WordPress\Configuration\Exceptions\InvalidConfigException;

use Symfony\Component\Yaml\Parser;


class YAMLConfigLoader extends AbstractConfigLoader{

	const EXT = 'yml';
	const PARAMS_KEY = 'parameters';

	public function __construct($environment = null){
		parent::__construct($environment);

		$this->setParser(new Parser());
	}


	function getExt(){
		return '.' . self::EXT;
	}


	function parseFile($path, $strict = false){
		$config = $this->parse($path, $strict);

		if(!$config) return;

		$this->validateFormat($config, $path);

		return $config[self::PARAMS_KEY];
	}


	protected function parse($file, $strict = false){
		if(file_exists($file)){
			$content = file_get_contents($file);
			return $this->parser->parse($content);
		}
		else{
			if($strict) throw new FileNotFoundException('Core Config', $file);
		}
	}


	protected function validateFormat($config, $path){
		if(! is_array($config)){
			throw new InvalidConfigException("The config file must return an instance of Array", $path);
		}

		if(! array_key_exists(self::PARAMS_KEY, $config)){
			throw new InvalidConfigException("Configuration requires `parameters` key", $path);
		}
	}


	function setParser(Parser $parser){
		$this->parser = $parser;
	}
}