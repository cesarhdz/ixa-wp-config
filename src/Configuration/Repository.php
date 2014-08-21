<?php

namespace Ixa\WordPress\Configuration;

use ArrayAccess;
use Countable;

class Repository implements ArrayAccess, Countable {

	private $params;

	function __construct(array $params){
		$this->params = $params;
	}

	function has($key){
		return array_key_exists($key, $this->params);
	}

	function merge(array $params){
		$this->params = array_merge($this->params, $params);
	}

	function offsetExists($offset){
		return $this->has($key);
	}
	
	function offsetGet($offset){
		return $this->params[$offset];
	}
	
	function offsetSet($offset, $value){
		$msg = 'Configuration is read-only. cannot be updated';
		throw new \BadFunctionCallException($msg);
	}
	
	function offsetUnset($offset){
		$msg = 'Configuration is read-only, cannot unset any key';
		throw new \BadFunctionCallException($msg);
	}

	function count(){
		return count($this->params);
	}
}