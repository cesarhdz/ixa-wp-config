<?php
namespace Ixa\WpConfig;

use Symfony\Component\Yaml\Parser;

class Configurator{


	const ENV_FILE = 'env.yml';


	protected $dir;
	protected $envVars;


	function __construct($dir){
		$this->setDir($dir);
	}


	function getEnvFilePath(){
		return $this->getDir() . self::ENV_FILE;
	}


	function loadEnvVars(){
		$file = file_get_contents($this->getEnvFilePath());
		$parser = $this->getParser();

		$this->envVars = $parser->parse($file);
	}

	function getEnvVars(){ return $this->envVars; }


	function getParser(){
		return new Parser();
	}


	function getDir(){ return $this->dir; }


	private function setDir($dir){
		if(is_dir($dir)){
			$this->dir = $dir;
		}
	}

}