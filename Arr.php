<?php

namespace phputils;

use DateTime;
use \ReflectionException;

class Arr {

	static function verify($string, $array, $isNotSetString="") {
		return isset($array[$string]) ? $array[$string] : $isNotSetString;
	}

	static function arrayToString($array, $separator=",") {
		return implode($separator,$array);
	}

	/*
		Percorre uma lista adicionando algum texto em cada item
	*/
	static function appendTextList($array, $textBefore="", $textAfter="") {
		foreach ($array as $key => $item) {
			$array[$key] = $textBefore . $item . $textAfter;
		}
		return $array;
	}
}
