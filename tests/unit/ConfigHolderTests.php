<?php

namespace Ixa\WordPress\Configuration;

class ConfigHolderTests extends \PHPUnit_Framework_TestCase{

	function setUp(){
		$this->dir =  get_config_dir('holder'); 
		$this->holder = new ConfigHolder();

		$this->holder->dir($this->dir);
	}


	function test_php_and_yaml_are_predefined_loaders(){

		$loader = $this->holder->getLoader('php');
		$this->assertInstanceOf('Ixa\\WordPress\\Configuration\\PHPConfigLoader',  $loader);


		$loader = $this->holder->getLoader('yaml');
		$this->assertInstanceOf('Ixa\\WordPress\\Configuration\\YAMLCOnfigLoader',  $loader);
	}


	function test_execute_loader_if_file_exists(){
		// when
		$config = $this->holder->load('config');

		// then
		$this->assertNotNull($config);
		$this->assertInstanceOf('Ixa\\WordPress\\Configuration\\Repository', $config);
	}


	function test_should_pass_environment_to_loader(){
		$holder = new ConfigHolder('test');

		$config = $holder->dir($this->dir)->load('merge');

		// then
		$this->assertCount(4, $config);
		$this->assertEquals('es_ES', $config['WP.LANG']);
	}



	function test_static_access(){
		// setup
		ConfigHolder::init('dev');

		//expect
		$this->assertInstanceOf(
			'Ixa\\WordPress\\Configuration\\ConfigHolder', 
			ConfigHolder::get()
		);
	}

}