<?php
namespace Ixa\WpConfig;

use Symfony\Component\Yaml\Parser;

class EnvFile{

	const PARAMS_KEY = 'parameters';

	protected $path;
	protected $parser;

	protected $params;


	function __construct($path = ''){
		$this->setPath($path);
	}


	function parse(){
		$file = file_get_contents($this->path);

		$this->params = $this->parser->parse($file);
	}

	function register(){
		foreach ($this->getEnvVar() as $key => $value) {
			define(strtoupper($key), $value);
		}
	}

	function getEnvVar(){ return $this->params[self::PARAMS_KEY]; }

	
	function setParams(array $params){
		$this->params = $params;
	}


	function setParser($parser){
		$this->parser = $parser;
	}

	function setPath($path){
		$this->path = $path;
	}

}