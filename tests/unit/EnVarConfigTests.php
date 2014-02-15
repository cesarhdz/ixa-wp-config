<?php

namespace Ixa\WordPress\Configuration;



class EnvVarConfigTest extends \PHPUnit_Framework_TestCase{


	function setUp(){

		$this->currentDir = dirname(__FILE__) . '/';
	}


	function testEnVarConfigCanBeCreatedWithAPath(){
		
		$config = new EnvVarConfig($this->currentDir);


		$this->assertSame($config->getDir(),$this->currentDir);

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

	function testGetPathContainsDirAndName(){
		$config = new EnvVarConfig($this->currentDir, 'custom');


		$this->assertSame(
			$config->getFilePath(),
			$this->currentDir . 'custom.yml',
			"The path of file must be dir plus filename"
			);
	}


	function testOnlyArraysWithParmsKeyValidAreSet(){

		$config = new EnvVarConfig('');

		$config->setParams(array(1,2,3,4,5));

		$this->assertCount(0, $config->getParams());

		$validParams = array("parameters" => array(
				"environment" => 'dev'
			));

		$config->setParams($validParams);

		$this->assertCount(1,$config->getParams());
	}


	function testParamsAreSaved(){
		$config = new EnvVarConfig('');
		$params = array("parameters" => array(
				'environment' => 'dev',
				'db_name' => 'wordpress', 
				'db_user' => 'root', 
				'db_host' => 'localhost', 
				'db_password' => '',
				'wp_home' => 'http://localhost:8000'
		));

		$config->setParams($params);
		$config->save();


		$constants = array('ENVIRONMENT', 'DB_NAME', 'DB_USER', 'DB_HOST', 'DB_PASSWORD', 'WP_HOME');

		foreach ($constants as $constant) {
			$this->assertTrue(
				defined($constant),
				"[${constant}] constant must be defined"
			);
		}
	}


	function testConfigLoad(){

		$config = $this->getConfig('valid');

		$config->load();

		$this->assertTrue(is_array($config->getParams()));
	}


	/**
	 * Get Config
	 * Return a EnvVarConfigObject
	 * @param  [type] $fileName file to load
	 * @return EnvVarConfig     new ConfigLoader ready to test
	 */
	function getConfig($fileName){

		$dir = get_config_dir('env-vars');

		return new EnvVarConfig($dir, $fileName);
	}


}