<?php


namespace Ixa\WpConfig;


use Symfony\Component\Yaml\Parser;

class EnvFileTests extends \PHPUnit_Framework_TestCase{


	function testAnEnvFileCanParseYaml(){

		$file = new EnvFile(get_config_dir('env-config').'env.yml');
		$file->setParser(new Parser());
		$file->parse();

		$this->assertTrue(is_array($file->getParams()));

	}


}