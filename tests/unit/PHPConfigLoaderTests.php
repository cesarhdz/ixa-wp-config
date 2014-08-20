<?php

namespace Ixa\WordPress\Configuration;

use Ixa\WordPress\Configuration\Exceptions\FileNotFoundException;

class PHPConfigTests extends \PHPUnit_Framework_TestCase{


	function setUp(){
		$this->currentDir = __DIR__ . '/';
		$this->config = new PHPConfigLoader($this->currentDir, 'config');
	}


	function test_should_thron_invalid_argument_exception_if_filename_is_not_given(){

		$this->setExpectedException('InvalidArgumentException');

		new PHPConfigLoader('no file ??');
	}



	function test_should_get_full_file_path(){
		$config = new PHPConfigLoader('', 'config');
		$this->assertSame('config.php', $config->getFileName());


		$config = new PHPConfigLoader('', 'config', 'dev');
		$this->assertSame('config.dev.php', $config->getEnvironmentFilePath());

	}




	// function testConfigLoad(){

	// 	$config = $this->getConfig();

	// 	$config->load();

	// 	$this->assertTrue(is_array($config->getParams()));
	// 	$this->assertCount(4, $config->getParams());
	// }


	// function testIfFileNotExistsWhenLoadingAnExceptionIsThrown(){

	// 	// Load a valid folder
	// 	$config = $this->getConfig();
	// 	$config->load();
	// 	$this->assertSame($config->getFileName(), 'config.php');

	// 	// Then an invalid folder
	// 	$this->setExpectedException('Ixa\\WordPress\\Configuration\\Exceptions\\FileNotFoundException');
	// 	$this->config->load();

	// }


	// function testIfConfigFileDoesntReturnArreayAndExceptionIsThrown(){
		
	// 	$this->setExpectedException('Ixa\\WordPress\\Configuration\\Exceptions\\InvalidConfigException');
		
	// 	$config = $this->getConfig('core', 'invalid');

	// 	$config->load();
	// }


	// function testConfigAndEnvironmentConfigAreLoaded(){

	// 	$config = $this->getConfig('merge');
	// 	$config->load();

	// 	$params = $config->getParams();

	// 	$this->assertCount(4, $params);
	// 	$this->assertEquals('es_ES', $params['WP_LANG']);
	// }


	// function testAllParamsAreRegisteredAsConstantsAndCannotBeOverrriden(){


	// 	$config = $this->getConfig();
	// 	$config->setParams(array(
	// 		'wp_lang' => 'es_ES',
	// 		'fs_method' => 'direct'
	// 	));

	// 	$config->save();
	// 	$config->save();
	// 	$config->save();

	// 	$this->assertEquals(FS_METHOD, 'direct');
	// 	$this->assertEquals(WP_LANG, 'es_ES');
	// }


	// /**
	//  * Get Config
	//  * Return a EnvironmentConfigObject
	//  * @param  [type] $fileName file to load
	//  * @return EnvironmentConfig     new ConfigLoader ready to test
	//  */
	// function getConfig($dir = 'core', $fileName = ''){

	// 	$dir = get_config_dir($dir);

	// 	return new CoreConfig($dir, $fileName);
	// }


}