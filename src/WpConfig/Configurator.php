<?php
namespace Ixa\WpConfig;


class Configurator{

	protected $dir;


	function __construct($dir){
		$this->setDir($dir);
	}


	function getDir(){ return $this->dir; }


	private function setDir($dir){
		if(is_dir($dir)){
			$this->dir = $dir;
		}
	}

}