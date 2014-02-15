<?php


namespace Ixa\WpConfig;


class ConfiguratorTests extends \PHPUnit_Framework_TestCase{

	function testAGeneratorCanBeConstructedWithADir(){

		$currentDir = dirname(__FILE__);
		$config = new Configurator($currentDir);


		$this->assertSame($config->getDir(),$currentDir);

	}

}