<?php

namespace Ixa\WordPress\Configuration;


class Configuration{


	protected $dir;
	protected $loaders;

	function __construct($dir){

		$this->setDir($dir);

		$this->loaders = array();

	}



	function getDir(){
		return $this->dir;
	}


	function bind($name, $function){
		$this->addLoader($name, call_user_func($function, $this->getDir()));
	}


	function getLoader($name){

		return $this->loaders[$name];

	}


	protected function addLoader($name, $obj){
		$this->loaders[$name] = $obj;
	}



	function setDir($dir){
		$this->dir = $dir;
	}


}