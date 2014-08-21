<?php

namespace Ixa\WordPress\Configuration;


interface ConfigurationLoader{

	function __construct($environment);

	/**
	 * Load
	 * Parse and save file into $this->params
	 * @return void
	 */
	function load($dir, $name);

	
	function find($dir, $name);


}