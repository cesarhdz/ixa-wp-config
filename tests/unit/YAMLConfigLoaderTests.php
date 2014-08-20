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


	function test_should_load_config(){
		$config = new YAMLConfigLoader(get_config_dir('yaml'), 'config');

		$config->load();

		$this->assertTrue(is_array($config->getParams()));
		$this->assertCount(6, $config->getParams());
	}


	function test_should_merge_default_and_environemnt_config(){
		// given
		$dir = get_config_dir('yaml');
		$config = new YAMLConfigLoader($dir, 'merge', 'test');

		// when
		$params = $config->load();

		// then
		$this->assertCount(4, $params);
		$this->assertEquals('es_ES', $params['WP_LANG']);
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