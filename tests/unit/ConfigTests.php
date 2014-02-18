<?php

namespace Ixa\WordPress\Configuration;

class ConfigTest extends \PHPUnit_Framework_TestCase{

	function setUp(){
		$this->dir =  get_config_dir('env-vars'); 

		$this->obj = new Config($this->dir);
	}


	function testConfigurationIsCreatedWithADir(){

		$this->assertSame($this->obj->getDir(), $this->dir);

	}


	function testAlDirsHaveTrailingSlash(){
		$config = new Config('noTrailingSlash');


		$this->assertEquals(
			$config->getDir(),
			'noTrailingSlash/',
			'In order to avoid concatenating  dir and config file named, getDir() must have trailingSlash'
			);
	}


	function testEnvironmentAndCoreLoadersArePredefined(){

		$loader = $this->obj->getLoader('environment');

		$this->assertInstanceOf('Ixa\\WordPress\\Configuration\\ConstantsConfig',  $loader);
		$this->assertInstanceOf('Ixa\\WordPress\\Configuration\\EnvironmentConfig',  $loader);


		$loader = $this->obj->getLoader('core');

		$this->assertInstanceOf('Ixa\\WordPress\\Configuration\\ConstantsConfig',  $loader);
		$this->assertInstanceOf('Ixa\\WordPress\\Configuration\\CoreConfig',  $loader);

	}

	function testCanRegisterLoaders(){

		$loader = $this->mockEnvLoader();

		$this->obj->bind('custom', function($dir) use ($loader){
			return $loader->setConstructorArgs(array($dir))->getMock();
		});



		$this->assertNotNull($this->obj->getLoader('environment'));
		$this->assertInstanceOf('Ixa\\WordPress\\Configuration\\ConfigLoader',  $this->obj->getLoader('environment'));
	}

	function testOnlyConfigLoadersCanBeBinded(){

		$this->setExpectedException('Exception');
		
		$this->obj->bind('invalid', function($dir){
			return array();
		});
	}


	function testAllRegisteredLoaderesAreRun(){

		$loaders = array('environment', 'core', 'custom1', 'custom2', 'custom3', 'custom4', 'custom5');

		// 10 loaders are bound
		foreach ($loaders as $name) {
			$loader = $this->getMock('Ixa\\WordPress\\Configuration\\ConfigLoader');
					
			$loader->expects($this->once())
				 ->method('load');

			$loader->expects($this->once())
				 ->method('save');

			$this->obj->bind($name, function($dir) use ($loader){
				return $loader;
			});

		}

		$this->obj->load();
	}


	protected function mockEnvLoader(array $methods = array()){
		return $this->mockLoader('EnvironmentConfig', $methods);
	}


	protected function mockCoreLoader(array $methods = array()){
		return $this->mockLoader('CoreConfig', $methods);
	}


	protected function mockLoader($class, array $methods = array()){
		$clazz = 'Ixa\\WordPress\\Configuration\\' . $class;

		return $this->getMockBuilder($clazz)->setMethods($methods);

	}

}