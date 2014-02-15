<?php

namespace Ixa\WordPress\Configuration;



class EnvVarConfigTest extends \PHPUnit_Framework_TestCase{


	function testEnVarConfigCanBeCreatedWithAPath(){
		
		$currentDir = dirname(__FILE__);
		$config = new EnvVarConfig($currentDir);


		$this->assertSame($config->getDir(),$currentDir);

	}


}