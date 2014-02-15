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


	function getEnvFile(){
		$path = $this->getDir() . self::ENV_FILE;

		return new EnvFile($path);
	}


	function loadEnvVars(){
		$envFile = $this->getEnvFile();

		$envFile->setParser(new Parser());
		$envFile->parse();
		$envFile->register();
	}

	function getEnvVars(){ return $this->envVars; }



	function getDir(){ return $this->dir; }


	private function setDir($dir){
		if(is_dir($dir)){
			$this->dir = $dir;
		}
	}

}