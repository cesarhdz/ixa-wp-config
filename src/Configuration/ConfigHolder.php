<?php

namespace Ixa\WordPress\Configuration;


class ConfigHolder{

	protected $dir;
	protected $environment;
	protected $loaders = array();


	protected static $defaultLoaders = array(
		'php' 	=> 	'Ixa\\WordPress\\Configuration\\PHPConfigLoader',
		'yaml' 	=> 	'Ixa\\WordPress\\Configuration\\YAMLConfigLoader'
	);

	function __construct($environment = null){
		$this->environment = $environment;

		$this->bindDefaultLoaders();
	}

	function registerLoader($name, $loader){
		self::$loaders[$name] = $loader;
	}


	function dir($dir){
		$this->setDir($dir);

		return $this;
	}


	function load($name){
		foreach ($this->loaders as $loader){


			if($loader->find($this->dir, $name)){
				return $loader->load($this->dir, $name);
			}
		}
	}

	function getLoader($name){
		return $this->loaders[$name];
	}

	protected function addLoader($name, ConfigurationLoader $obj){
		$this->loaders[$name] = $obj;
	}


	protected function setDir($dir){
		$this->dir = rtrim($dir, '/') . '/';
	}


	protected function bindDefaultLoaders(){
		$this->loaders = array();

		foreach (self::$defaultLoaders as $key => $clazz){
			$this->addLoader($key, new $clazz($this->environment));
		}
	}


	/**
	 * Autcontainer
	 * Eventhoug singletons are not a good practice, WordPress
	 * doen't have a dependency Container, so using static methods
	 * we can get the same instance in the whole app
	 */
	private static $instance;

	static function init($dev){
		self::$instance = new self($dev);
	}

	static function get(){
		return self::$instance;
	}
}

