<?php


namespace Ixa\WpConfig;


class ConfiguratorTests extends \PHPUnit_Framework_TestCase{

	function testAGeneratorCanBeConstructedWithADir(){

		$currentDir = dirname(__FILE__);
		$config = new Configurator($currentDir);


		$this->assertSame($config->getDir(),$currentDir);
	}


	function testAnEnvFileIsReturned(){
		$dir = get_config_dir('env-config');
		$config = new Configurator($dir);

		$file = $config->getEnvFile();

		$this->assertInstanceOf('Ixa\\WpConfig\\EnvFile', $file);
	}




}