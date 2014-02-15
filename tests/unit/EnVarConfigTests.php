<?php

namespace Ixa\WordPress\Configuration;



class EnvVarConfigTest extends \PHPUnit_Framework_TestCase{


	function setUp(){

		$this->currentDir = dirname(__FILE__) . '/';
	}


	function testEnVarConfigCanBeCreatedWithAPath(){
		
		$config = new EnvVarConfig($this->currentDir);


		$this->assertSame($config->getDir(),$this->currentDir);

	}


	function testCanGetAndSetNameOfFile(){

		$config = new EnvVarConfig('');

		$this->assertSame(
			$config->getFileName(), 
			'env.yml', 
			'By default the .env.yml file is loaded'
		);


		$config = new EnvVarConfig('', 'custom');

		$this->assertSame(
			$config->getFileName(),
			'custom.yml',
			'If passed as second argument in constructor, default path can be overriten'
			);
	}

	function testGetPathContainsDirAndName(){
		$config = new EnvVarConfig($this->currentDir, 'custom');


		$this->assertSame(
			$config->getFilePath(),
			$this->currentDir . 'custom.yml',
			"The path of file must be dir plus filename"
			);
	}


	function testConfigLoad(){

		$config = $this->getConfig('valid');

		$config->load();

		$this->assertTrue(is_array($config->getParams()));
	}


	/**
	 * Get Config
	 * Return a EnvVarConfigObject
	 * @param  [type] $fileName file to load
	 * @return EnvVarConfig     new ConfigLoader ready to test
	 */
	function getConfig($fileName){

		$dir = get_config_dir('env-vars');

		return new EnvVarConfig($dir, $fileName);
	}


}