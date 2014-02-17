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


	function testEnvironmentLoaderIsPredefined(){

		$this->assertNotNull($this->obj->getLoader('environment'));
		$this->assertInstanceOf('Ixa\\WordPress\\Configuration\\ConfigLoader',  $this->obj->getLoader('environment'));

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

		// 10 loaders are bound
		for ($i=0; $i < 10; $i++) {
			
			$loader = $this->getMock('Ixa\\WordPress\\Configuration\\ConfigLoader');
					
			$loader->expects($this->once())
				 ->method('load');

			$loader->expects($this->once())
				 ->method('save');

			$name = ($i == 0) ? 'environment' : 'e-'.$i;

			$this->obj->bind($name, function($dir) use ($loader){
				return $loader;
			});

		}

		$this->obj->load();
	}


	protected function mockEnvLoader(array $methods = array()){
		return $this
			->getMockBuilder('Ixa\\WordPress\\Configuration\\EnvironmentConfig')
			->setMethods($methods);
	}

}