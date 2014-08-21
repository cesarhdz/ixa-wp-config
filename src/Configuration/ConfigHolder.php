<?php

namespace Ixa\WordPress\Configuration;


class CoonfigHolder{


	protected $dir;
	protected $name;
	protected $loaders;


	protected static $defaultLoaders = array(
		'environment' => 	'Ixa\\WordPress\\Configuration\\PHPConfigLoader',
		'core' => 			'Ixa\\WordPress\\Configuration\\YAMLConfigLoader'
	);

	function __construct($dir, $name, $environment = null){
		$this->setDir($dir);
		$this->name = $name;

		$this->bindDefaultLoaders();
	}


	/**
	 * Load
	 * Call all registered Config Loaders
	 * @return void 
	 */
	function load(){
		foreach ($this->loaders as $loader){
			// A different method can be called based on class
			$method = $this->getMethodFromLoader($loader);
			
			$this->$method($loader);
		}
	}

	function getMethodFromLoader(ConfigLoader $loader){
		return ($loader instanceof ConstantsConfig) ? 'loadAndDefine' : 'loadAndSave';
	}


	protected function loadAndDefine(ConstantsConfig $loader){
		$loader->load();
		$loader->save();
	}

	protected function loadAndSave(ConfigLoader $loader){
		$loader->load();
	}


	function getDir(){
		return $this->dir;
	}


	function bind($name, $function){

		$method = (array_key_exists($name, self::$defaultLoaders)) 
				? 'addDefaultLoader' 
				: 'addLoader';


		// AddLoader		
		$this->$method($name, call_user_func($function, $this->getDir()));
	}


	function getLoader($name){
		return $this->loaders[$name];
	}


	protected function addLoader($name, ConfigLoader $obj){
		$this->loaders[$name] = $obj;
	}



	protected function addDefaultLoader($name, ConstantsConfig $obj){
		$this->loaders[$name] = $obj;
	}



	function setDir($dir){
		$this->dir = rtrim($dir, '/') . '/';
	}


	protected function bindDefaultLoaders(){
		$this->loaders = array();

		foreach (self::$defaultLoaders as $key => $clazz){
			$this->addLoader($key, new $clazz($this->getDir($this->dir, $this->name, $this->environment)));
		}
	}
}


// Preset
ConfigHolder::setEnvironment(ENVIRONMENT);
ConfigHolder::setBaseDir($defaultDir);
ConfigHolder::setDefaultLoader('yaml');


$config = ConfigHolder::loader('php')->get('name');
