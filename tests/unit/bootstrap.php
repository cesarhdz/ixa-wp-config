<?php



require __DIR__ .'/../../vendor/autoload.php';


define('ENVIRONMENT', 'test');


function get_config_dir($name){


	return __DIR__ . '/../fixtures/' . $name . '/';


}