<?php

namespace Ixa\WordPress\Configuration;



class EnvVarConfigTest extends \PHPUnit_Framework_TestCase{


	function setUp(){

		$this->currentDir = dirname(__FILE__) . '/';
		$this->config = new EnvVarConfig('');
	}


	function testEnVarConfigCanBeCreatedWithAPath(){
		
		$config = new EnvVarConfig($this->currentDir);


		$this->assertSame($config->getDir(),$this->currentDir);

	}


	function testCanGetAndSetNameOfFile(){

		$this->assertSame(
			$this->config->getFileName(), 
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

		$this->config->setParams(array(1,2,3,4,5));

		$this->assertCount(0, $this->config->getParams());

		$validParams = array("parameters" => array(
				"environment" => 'dev'
			));

		$this->config->setParams($validParams);

		$this->assertCount(1,$this->config->getParams());
	}



	function testOnlyWhiteListVarsAreSaved(){

		$this->config->setParams(array("parameters"=> array(
			'environment' => 'dev',
			'invalidKey' => 'prod'
			)));


		// var_dump($config->getParams());


		$this->assertContains(
			'dev',
			$this->config->getParams(),
			'environment is a valid param and must be registered'
			);

		$this->assertNotContains(
			'prod',
			$this->config->getParams(),
			'invalidaKey is not a valid param and must not be registered'
			);
	}

	var $validParams = array("parameters" => array(
			'db_name' => 'wordpress', 
			'db_user' => 'root', 
			'db_host' => 'localhost', 
			'db_password' => '',
			'wp_home' => 'http://localhost:8000'
	));

	function testParamsAreSaved(){

		$this->config->setParams($this->validParams);
		$this->config->save();

		// Bacuase constant can be only defined once, 
		// environemnt var is not set in this test
		$constants = array('DB_NAME', 'DB_USER', 'DB_HOST', 'DB_PASSWORD', 'WP_HOME');

		foreach ($constants as $constant) {
			$this->assertTrue(
				defined($constant),
				"[${constant}] constant must be defined"
			);
		}
	}

	function testDoesntTryToSetDefinedConstants(){

		$this->config->setParams($this->validParams);

		$this->config->save();
		$this->config->save();

		$this->assertTrue(defined('DB_NAME'), "Constants are defined only Once");
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