<?php

namespace Ixa\WordPress\Configuration;

use Ixa\WordPress\Configuration\Exceptions\FileNotFoundException;

class YAMLConfigLoadeerTest extends \PHPUnit_Framework_TestCase{


	function setUp(){
		$this->loader = new YAMLConfigLoader();
		$this->dir = get_config_dir('yaml');
	}



	function test_should_get_full_file_path(){
		// where
		$name = 'config';
		$env = 'dev';

		// expect
		$result = $this->loader->getFileName($this->dir, $name); 
		$this->assertSame($this->dir . 'config.yml', $result);
		

		$result = $this->loader->getFileName($this->dir, $name, $env);
		$this->assertSame($this->dir . 'config.dev.yml', $result);
	}


	function test_should_load_config(){
		// when
		$config = $this->loader->load($this->dir, 'config');

		// then
		$this->assertInstanceOf('Ixa\\WordPress\\Configuration\\Repository', $config);
		$this->assertCount(6, $config);
	}


	function test_should_merge_default_and_environemnt_config(){
		// given
		$loader = new YAMLConfigLoader('test');

		// when
		$config = $loader->load($this->dir, 'merge');

		// then
		$this->assertCount(4, $config);
		$this->assertEquals('es_ES', $config['WP.LANG']);
	}
}