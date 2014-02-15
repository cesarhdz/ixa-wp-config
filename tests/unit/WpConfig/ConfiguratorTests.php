<?php


namespace Ixa\WpConfig;


class ConfiguratorTests extends \PHPUnit_Framework_TestCase{

	function testAGeneratorCanBeConstructedWithADir(){

		$currentDir = dirname(__FILE__);
		$config = new Configurator($currentDir);


		$this->assertSame($config->getDir(),$currentDir);
	}


	function testCanReadEnvFile(){

		$dir = get_config_dir('env-config');
		$config = new Configurator($dir);

		$config->loadEnvVars();

		$this->assertTrue(is_array($config->getEnvVars()));
	}




}