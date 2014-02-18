<?php

namespace Ixa\WordPress\Configuration;

use Ixa\WordPress\Configuration\Exceptions\FileNotFoundException;

class CoreConfigTest extends \PHPUnit_Framework_TestCase{


	function setUp(){

		$this->currentDir = dirname(__FILE__) . '/';
		$this->config = new CoreConfig('');
	}


	function testEnVarConfigCanBeCreatedWithAPath(){
		
		$config = new CoreConfig($this->currentDir);


		$this->assertSame($config->getDir(),$this->currentDir);

	}


	function testCanGetAndSetNameOfFile(){

		$this->assertSame(
			$this->config->getFileName(), 
			'config.php', 
			'By default the config.php file is loaded'
		);


		$config = new CoreConfig('', 'custom');

		$this->assertSame(
			$config->getFileName(),
			'custom.php',
			'If passed as second argument in constructor, default path can be overriten'
			);
	}

	function testGetPathContainsDirAndName(){
		$config = new CoreConfig($this->currentDir, 'custom');


		$this->assertSame(
			$config->getFilePath(),
			$this->currentDir . 'custom.php',
			"The path of file must be dir plus filename"
			);
	}




	function testConfigLoad(){

		$config = $this->getConfig('');

		$config->load();

		$this->assertTrue(is_array($config->getParams()));
	}


	function testIfFileNotExistsWhenLoadingAnExceptionIsThrown(){

		// Load a valid folder
		$config = $this->getConfig('');
		$config->load();
		$this->assertSame($config->getFileName(), 'config.php');

		// Then an invalid folder
		$this->setExpectedException('Ixa\\WordPress\\Configuration\\Exceptions\\FileNotFoundException');
		$this->config->load();

	}


	/**
	 * Get Config
	 * Return a EnvironmentConfigObject
	 * @param  [type] $fileName file to load
	 * @return EnvironmentConfig     new ConfigLoader ready to test
	 */
	function getConfig($fileName){

		$dir = get_config_dir('core');

		return new CoreConfig($dir, $fileName);
	}


}