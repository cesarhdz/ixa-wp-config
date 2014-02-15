<?php
namespace Ixa\WpConfig;

use Symfony\Component\Yaml\Parser;

class EnvFile{

	protected $path;

	protected $params;


	function __construct($path){
		$this->path = $path;
	}



}