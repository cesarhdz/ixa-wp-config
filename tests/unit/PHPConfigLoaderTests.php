<?php

namespace Ixa\WordPress\Configuration;

use Ixa\WordPress\Configuration\Exceptions\FileNotFoundException;

class PHPConfigTests extends \PHPUnit_Framework_TestCase{


	function setUp(){
		$this->loader = new PHPConfigLoader();
		$this->dir = get_config_dir('php');
	}



	function test_should_get_full_file_path(){
		// where
		$name = 'config';
		$env = 'dev';

		// expect
		$result = $this->loader->getFileName($this->dir, $name); 
		$this->assertSame($this->dir . 'config.php', $result);
		

		$result = $this->loader->getFileName($this->dir, $name, $env);
		$this->assertSame($this->dir . 'config.dev.php', $result);
	}


	function test_should_load_config(){
		// given
		$name = 'config';

		// when
		$config = $this->loader->load($this->dir, $name);

		// then
		$this->assertInstanceOf('Ixa\\WordPress\\Configuration\\Repository', $config);
		$this->assertCount(4, $config);
	}


	function test_should_throw_exception_if_array_is_not_returned(){
		// expect
		$this->setExpectedException('Ixa\\WordPress\\Configuration\\Exceptions\\InvalidConfigException');
		
		// when
		$this->loader->load($this->dir, 'invalid');
	}


	function test_should_throw_exception_if_main_file_doesnt_exists(){
		// expect
		$this->setExpectedException('Ixa\\WordPress\\Configuration\\Exceptions\\FileNotFoundException');
		
		// when
		$this->loader->load($this->dir, 'not-found');
	}


	function test_should_merge_default_and_environemnt_config(){
		// given
		$loader = new PHPConfigLoader('test');

		// when
		$config = $loader->load($this->dir, 'merge');

		// then
		$this->assertCount(4, $config);
		$this->assertEquals('es_ES', $config['WP_LANG']);
	}
}