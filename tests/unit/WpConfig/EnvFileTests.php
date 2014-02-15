<?php


namespace Ixa\WpConfig;


use Symfony\Component\Yaml\Parser;

class EnvFileTests extends \PHPUnit_Framework_TestCase{


	function testAnEnvFileCanParseYaml(){

		$file = new EnvFile(get_config_dir('env-config').'env.yml');
		$file->setParser(new Parser());
		$file->parse();

		$this->assertTrue(is_array($file->getEnvVar()));

	}


	function testEnvFileRegisterConstants(){

		$params = array(
			"parameters" => array(
				'environment' => 'dev',
				'db_name' => 'wordpress', 
				'db_user' => 'root', 
				'db_host' => 'localhost', 
				'db_password' => '',
				'wp_home' => 'http://localhost:8000'
			)
		);

		$file = new EnvFile();
		$file->setParams($params);
		$file->register();


		$this->assertTrue(defined('DB_NAME'));
		$this->assertTrue(defined('DB_USER'));
		$this->assertTrue(defined('DB_HOST'));
		$this->assertTrue(defined('DB_PASSWORD'));
		$this->assertTrue(defined('WP_HOME'));
		$this->assertTrue(defined('ENVIRONMENT'));
	}


}