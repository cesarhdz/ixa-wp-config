<?php

namespace Ixa\WordPress\Configuration;

use Ixa\WordPress\Configuration\Exceptions\FileNotFoundException;

class PHPConfigTests extends \PHPUnit_Framework_TestCase{


	function setUp(){
		$this->currentDir = __DIR__ . '/';
		$this->config = new PHPConfigLoader($this->currentDir, 'config');
	}


	function test_should_thron_invalid_argument_exception_if_filename_is_not_given(){

		$this->setExpectedException('LogicException');

		$config = new PHPConfigLoader('no file ??');
		$config->load();
	}



	function test_should_get_full_file_path(){
		$config = new PHPConfigLoader('', 'config');
		$this->assertSame('config.php', $config->getFileName());


		$config = new PHPConfigLoader('', 'config', 'dev');
		$this->assertSame('config.dev.php', $config->getEnvironmentFilePath());

	}


	function test_should_load_config(){
		$config = new PHPConfigLoader(get_config_dir('php'), 'config');

		$config->load();

		$this->assertTrue(is_array($config->getParams()));
		$this->assertCount(4, $config->getParams());
	}


	function test_should_throw_exception_if_array_is_not_returned(){
		// expect
		$this->setExpectedException('Ixa\\WordPress\\Configuration\\Exceptions\\InvalidConfigException');
		
		//given
		$config = new PHPConfigLoader(get_config_dir('php'), 'invalid');

		// when
		$config->load();
	}


	function test_should_throw_exception_if_main_file_doesnt_exists(){
		// expect
		$this->setExpectedException('Ixa\\WordPress\\Configuration\\Exceptions\\FileNotFoundException');
		
		// given
		$config = new PHPConfigLoader(get_config_dir('php'), 'not-found');

		// when
		$config->load();
	}


	function test_should_merge_default_and_environemnt_config(){
		// given
		$dir = get_config_dir('php');
		$config = new PHPConfigLoader($dir, 'merge', 'test');

		// when
		$params = $config->load();

		// then
		$this->assertCount(4, $params);
		$this->assertEquals('es_ES', $params['WP_LANG']);
	}
}