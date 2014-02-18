<?php



require dirname(__FILE__) .'/../../vendor/autoload.php';


define('ENVIRONMENT', 'test');


function get_config_dir($name){



	return dirname(__FILE__) . '/../fixtures/' . $name . '/';


}