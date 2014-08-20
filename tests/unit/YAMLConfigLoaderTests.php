<?php

namespace Ixa\WordPress\Configuration;

use Ixa\WordPress\Configuration\Exceptions\FileNotFoundException;

class YAMLConfigLoadeerTest extends \PHPUnit_Framework_TestCase{


	
	function test_should_get_full_file_path(){
		$config = new YAMLConfigLoader('', '.env');
		$this->assertSame('.env.yml', $config->getFileName());


		$config = new YAMLConfigLoader('', '.env', 'dev');
		$this->assertSame('.env.dev.yml', $config->getEnvironmentFilePath());

	}



	/**
	 * Get Config
	 * Return a EnvironmentConfigObject
	 * @param  [type] $fileName file to load
	 * @return EnvironmentConfig     new ConfigLoader ready to test
	 */
	function getConfig($fileName){

		$dir = get_config_dir('env-vars');

		return new EnvironmentConfig($dir, $fileName);
	}


}