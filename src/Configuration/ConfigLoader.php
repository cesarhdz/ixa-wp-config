<?php

namespace Ixa\WordPress\Configuration;


interface ConfigLoader{

	function __construct($dir, $filename = null);

	/**
	 * Load
	 * Parse and save file into $this->params
	 * @return void
	 */
	function load();

	/**
	 * Save
	 * Register all params as constants
	 * @return void
	 */
	function save();

	function getParams();

	function getFileName();

	function getDir();

}