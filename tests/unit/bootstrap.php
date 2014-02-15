<?php


require dirname(__FILE__) .'/../../vendor/autoload.php';


function get_config_dir($name){

	return dirname(__FILE__) . '/../fixtures/' . $name . '/';

}