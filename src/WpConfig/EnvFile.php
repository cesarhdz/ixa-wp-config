<?php
namespace Ixa\WpConfig;

use Symfony\Component\Yaml\Parser;

class EnvFile{

	protected $path;
	protected $parser;

	protected $params;


	function __construct($path){
		$this->path = $path;
	}


	function parse(){
		$file = file_get_contents($this->path);

		$this->params = $this->parser->parse($file);
	}

	function register(){


	}

	function getParams(){ return $this->params; }


	function setParser($parser){
		$this->parser = $parser;
	}

}