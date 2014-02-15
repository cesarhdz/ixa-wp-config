<?php

namespace Ixa\WordPress\Configuration\Exceptions;


class FileNotFoundException extends \Exception{

	function __construct($name, $path){

		parent::__construct(
			"The _${name}_ Configuration file doesn't exists in `${path}`"
		);

	}


}