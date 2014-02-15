<?php

namespace Ixa\WordPress\Configuration;



class EnvVarConfigTest extends \PHPUnit_Framework_TestCase{



	function testEnVarConfigCanBeCreatedWithAPath(){
		
		$currentDir = dirname(__FILE__);
		$config = new EnvVarConfig($currentDir);


		$this->assertSame($config->getDir(),$currentDir);

	}


	function testCanGetAndSetNameOfFile(){

		$config = new EnvVarConfig('');

		$this->assertSame(
			$config->getFileName(), 
			'env.yml', 
			'By default the .env.yml file is loaded'
		);


		$config = new EnvVarConfig('', 'custom');

		$this->assertSame(
			$config->getFileName(),
			'custom.yml',
			'If passed as second argument in constructor, default path can be overriten'
			);
	}


}