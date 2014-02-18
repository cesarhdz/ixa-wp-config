<?php

namespace Ixa\WordPress\Configuration;

use Ixa\WordPress\Configuration\Exceptions\FileNotFoundException;

class CoreConfigTest extends \PHPUnit_Framework_TestCase{


	function setUp(){

		$this->currentDir = __DIR__ . '/';
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

	function testEnviromentPath(){
		$config = new CoreConfig('');

		$this->assertSame(
			$config->getEnvironmentFilePath(),
			'config.test.php'
			// "The path of configuration by environment must end with config.test.php"

			);

	}




	function testConfigLoad(){

		$config = $this->getConfig();

		$config->load();

		$this->assertTrue(is_array($config->getParams()));
		$this->assertCount(4, $config->getParams());
	}


	function testIfFileNotExistsWhenLoadingAnExceptionIsThrown(){

		// Load a valid folder
		$config = $this->getConfig();
		$config->load();
		$this->assertSame($config->getFileName(), 'config.php');

		// Then an invalid folder
		$this->setExpectedException('Ixa\\WordPress\\Configuration\\Exceptions\\FileNotFoundException');
		$this->config->load();

	}


	function testIfConfigFileDoesntReturnArreayAndExceptionIsThrown(){
		
		$this->setExpectedException('Ixa\\WordPress\\Configuration\\Exceptions\\InvalidConfigException');
		
		$config = $this->getConfig('core', 'invalid');

		$config->load();
	}


	function testConfigAndEnvironmentConfigAreLoaded(){

		$config = $this->getConfig('merge');
		$config->load();

		$params = $config->getParams();

		$this->assertCount(4, $params);
		$this->assertEquals('es_ES', $params['WP_LANG']);
	}


	function testAllParamsAreRegisteredAsConstantsAndCannotBeOverrriden(){


		$config = $this->getConfig();
		$config->setParams(array(
			'wp_lang' => 'es_ES',
			'fs_method' => 'direct'
		));

		$config->save();
		$config->save();
		$config->save();

		$this->assertEquals(FS_METHOD, 'direct');
		$this->assertEquals(WP_LANG, 'es_ES');
	}


	/**
	 * Get Config
	 * Return a EnvironmentConfigObject
	 * @param  [type] $fileName file to load
	 * @return EnvironmentConfig     new ConfigLoader ready to test
	 */
	function getConfig($dir = 'core', $fileName = ''){

		$dir = get_config_dir($dir);

		return new CoreConfig($dir, $fileName);
	}


}