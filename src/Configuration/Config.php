<?php

namespace Ixa\WordPress\Configuration;


class Config{


	protected $dir;
	protected $loaders;


	protected static $defaultLoaders = array(
		'environment' => 'Ixa\\WordPress\\Configuration\\EnvironmentConfig',
		'core' => 'Ixa\\WordPress\\Configuration\\CoreConfig'
	);

	function __construct($dir){

		$this->setDir($dir);

		$this->bindDefaultLoaders();
	}


	/**
	 * Load
	 * Call all registered Config Loaders
	 * @return void 
	 */
	function load(){
		foreach ($this->loaders as $loader){
			$loader->load();
			$loader->save();
		}
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


	protected function addLoader($name, ConfigLoader $obj){
		$this->loaders[$name] = $obj;
	}



	function setDir($dir){
		$this->dir = rtrim($dir, '/') . '/';
	}


	protected function bindDefaultLoaders(){

		$this->loaders = array();


		foreach (self::$defaultLoaders as $key => $clazz) {
			$this->addLoader($key, new $clazz($this->getDir()));
		}
	}


}