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

}