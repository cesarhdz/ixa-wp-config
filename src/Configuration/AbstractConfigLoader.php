<?php

namespace Ixa\WordPress\Configuration;


abstract class AbstractConfigLoader implements ConfigurationLoader{

	private $environment;

	public function __construct($environment = null){
		$this->setEnvironment($environment);
	}

	abstract public function getExt();

	abstract protected function parseFile($path);


	/**
	 * Load
	 * Parse and save file into $this->params
	 * @return void
	 */
	function load($dir, $filename){
		$baseFile = $this->getFileName($dir, $filename);

		// Base file must exits
		if(! file_exists($baseFile)){
			throw new Exceptions\FileNotFoundException(__CLASS__, $baseFile);
		}

		// Strat config repo
		$config = $this->parseFile($baseFile);
		$repo = new Repository($config);

		if($this->environment){
			$envFile = $this->getFilename($dir, $filename, $this->environment);

			if(file_exists($envFile)){
				$config = $this->parseFile($envFile);
				$repo->merge($config);
			}
		}

		return $repo;
	}


	function find($dir, $name){
		$path = $this->getFilename($dir, $name);

		return(file_exists($path));
	}

	private function setEnvironment($environment){
		$this->environment = $environment;
	}

	function getFilename($dir, $file, $env = null){
		$name = ($env) ? $file . '.' . $env : $file;

		return $dir . $name. $this->getExt();
	}
}