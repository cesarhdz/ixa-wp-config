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

	/**
	 * Save
	 * Register all params as constants
	 * @return void
	 */
	function supports($name);


}