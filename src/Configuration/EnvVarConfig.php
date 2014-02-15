<?php

namespace Ixa\WordPress\Configuration;


class EnvVarConfig{

	protected $dir;


	public function __construct($dir){
		$this->setDir($dir);
	}





	function getDir(){
		return $this->dir;
	}


	function setDir($dir){
		$this->dir = $dir;
	}
}