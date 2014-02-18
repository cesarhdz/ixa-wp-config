<?php

namespace Ixa\WordPress\Configuration\Exceptions;


class InvalidConfigException extends \Exception{

	function __construct($msg, $path){

		parent::__construct(
			"The configuration file `${path}` is Invalid because ${msg}"
		);

	}


}