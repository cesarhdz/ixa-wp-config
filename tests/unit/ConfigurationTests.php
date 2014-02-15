<?php

namespace Ixa\WordPress\Configuration;

class ConfigurationTest extends \PHPUnit_Framework_TestCase{

	function setUp(){
		$this->dir =  get_config_dir('env-vars'); 

		$this->obj = new Configuration($this->dir);
	}


	function testConfigurationIsCreatedWithADir(){

		$this->assertSame($this->obj->getDir(), $this->dir);

	}


	function testEnvironmentLoaderIsPredefined(){

		$this->assertNotNull($this->obj->getLoader('environment'));

	}

	function testCanRegisterLoaders(){

		$loader = $this->mockEnvLoader();

		$this->obj->bind('custom', function($dir) use ($loader){
			return $loader->setConstructorArgs(array($dir))->getMock();
		});



		$this->assertNotNull($this->obj->getLoader('environment'));
	}


	function mockEnvLoader(array $methods = array()){
		return $this
			->getMockBuilder('Ixa\\WordPress\\Configuration\\EnvironmentConfig')
			->setMethods($methods);
	}

}