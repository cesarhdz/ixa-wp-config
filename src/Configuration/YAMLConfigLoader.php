<?php

namespace Ixa\WordPress\Configuration;

use Ixa\WordPress\Configuration\Exceptions\FileNotFoundException;

use Symfony\Component\Yaml\Parser;


class YAMLConfigLoader extends AbstractConfigLoader{

	const EXT = 'yml';
	const PARAMS_KEY = 'parameters';

	public function __construct($dir, $fileName = null, $environment = null){
		parent::__construct($dir, $fileName, $environment);

		$this->setParser(new Parser());
	}


	function getExt(){
		return '.' . self::EXT;
	}


	/**
	 * Load
	 * Parse and save file into $this->params
	 * @return void
	 */
	function load(){
		$this->loadFile($this->getFilePath());
		$this->loadFile($this->getEnvironmentFilePath(), false);

		// Return params
		return new Repository($this->getParams());
	}


	function setParser(Parser $parser){
		$this->parser = $parser;
	}
}