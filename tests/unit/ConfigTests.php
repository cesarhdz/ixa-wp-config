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

	var $loaders = array(
		'environment' 	=>  'ConstantsConfig',
		'core'			=>  'ConstantsConfig',
		'custom1'		=>  'ConfigLoader',
		'custom2'		=>  'ConfigLoader'
	);

	function testAllRegisteredLoaderesAreRun(){

		foreach ($this->loaders as $name => $clazz) {

			$loader = $this->mockLoader($clazz);

			$this->obj->bind($name, function($dir) use ($loader){

				$mock = $loader->setConstructorArgs(array($dir))->getMock();
	
				$mock->expects($this->once())
					 ->method('load');

				return $mock;
			});
		}

		$this->obj->load();
	}

	
	function testOnlyConstantLoadersAreSaved(){

		foreach ($this->loaders as $name => $clazz) {

			$loader = $this->mockLoader($clazz);

			$this->obj->bind($name, function($dir) use ($loader, $clazz){

				$mock = $loader->setConstructorArgs(array($dir))->getMock();
	

				if($clazz == 'ConstantsConfig'){

					$mock->expects($this->once())
						 ->method('save');
					
				}else{

					$mock->expects($this->never())
						 ->method('save');
				}


				return $mock;
			});
		}

		$this->obj->load();


	}


	function testEnvironmentConfigMustBeAnInstanceOfConstantsConfig(){

		$loader = $this->getMock('Ixa\\WordPress\\Configuration\\ConfigLoader');

		//@TODO It's thworn because addDefaultLoader only accepts ConstantsConfig loaders
		$this->setExpectedException('PHPUnit_Framework_Error');

		$this->obj->bind('environment', function($dir) use ($loader){
			return $loader;
		});		

	}

	function testCoreConfigMustBeAnInstanceOfConstantsConfig(){
		$loader = $this->getMock('Ixa\\WordPress\\Configuration\\ConfigLoader');

		$this->setExpectedException('PHPUnit_Framework_Error');

		$this->obj->bind('core', function($dir) use ($loader){
			return $loader;
		});
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