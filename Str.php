<?php

namespace phputils;

use DateTime;
use \ReflectionException;

class Str {

	// Formato de moeda
	static function currency($number) {
		return number_format(floatval($number), 2, ',', '');
	}

	static function currencyPoint($number) {
		$number = str_replace(",", ".", $number);
		return number_format(floatval($number), 2, '.', '');
	}

	// Formato cartao crédito
	static function cardNumber($number) {

		$formatingNumber = substr($number, 0, 4) . "&nbsp;&nbsp;";
		$formatingNumber .= substr($number, 4, 4) . "&nbsp;&nbsp;";
		$formatingNumber .= substr($number, 8, 4) . "&nbsp;&nbsp;";
		$formatingNumber .= substr($number, 12, 4);
		return $formatingNumber;
	}

	static function cardNumberGroups($number): array {
		$groups[0] = substr($number, 0, 4);
		$groups[1] = substr($number, 4, 4);
		$groups[2] = substr($number, 8, 4);
		$groups[3] = substr($number, 12, 4);
		return $groups;
	}

	static function secureCardNumber($number) {
		$formatingNumber = "xxxx xxxx xxxx " . substr($number, 12, 4);
		return $formatingNumber;
	}

	static function lastCardNumbers($number) {
		return substr($number, 12, 4);
	}

	static function removeAcentos($string){
			$chars = [
				"/(á|à|ã|â|ä)/",
				"/(Á|À|Ã|Â|Ä)/",
				"/(é|è|ê|ë)/",
				"/(É|È|Ê|Ë)/",
				"/(í|ì|î|ï)/",
				"/(Í|Ì|Î|Ï)/",
				"/(ó|ò|õ|ô|ö)/",
				"/(Ó|Ò|Õ|Ô|Ö)/",
				"/(ú|ù|û|ü)/",
				"/(Ú|Ù|Û|Ü)/",
				"/(ñ)/",
				"/(Ñ)/"
			];

	    return preg_replace(
				$chars,
				explode(" ","a A e E i I o O u U n N"),
				$string);
	}

	static function replace($replaces, $string) {

		$keys = [];
		$values = [];

		foreach ($replaces as $key => $value) {
			$keys[] = $key;
			$values[] = $value;
		}

		return str_replace($keys, $values, $string);
	}

	// A string deve entrar CamelCase, ou Kebab-case
	static function snakeCase($string) {

		$string = strtolower($string);

		// Remove espaços em branco
		$string = preg_replace("/ /", "_", $string);
		$string = preg_replace("/-/", "_", $string);

		// preg_match_all("/[A-Z]*|[-]/", $string, $matches);

		// $keys = [];
		// $values = [];
		//
		// foreach($matches[0] as $match) {
		// 	// var_dump($match);
		// 	$keys[] = $match;
		// 	// $values[] = "_" . strtolower($match);
		// 	$values[] = strtolower($match);
		// }
		//
		// $string = str_replace($keys, $values, $string);
		// if (substr($string, 0,1) == "_") {
		// 	$string = substr($string, 1);
		// }

		return $string;
	}


	/**
	 * Converte uma frase para um padrão camel, kebab, snake ou pascal case
	 * 
	 * @param case camel|kebab|snake|pascal
	 */
	static function convertPhraseToCase($str, $case) {

		$desc = strtolower($str);

		if ($case == "camel") {
			return preg_replace_callback('/\s./', function ($matches) {
				return strtoupper($matches[0][1]);
			}, $desc);
		}
		if ($case == "snake") {
			return preg_replace_callback('/\s./', function ($matches) {
				return "_".$matches[0][1];
			}, $desc);
		}
		if ($case == "kebab") {
			//
		}
		if ($case == "pascal") {
			//
		}

	}

	static function convertCase($str, $caseIn, $toCase) {
		$patterns = [
			"camel"=> ["pattern"=>"/[A-Z]/", "adjust"=>"", 
				"adjustFunction"=>"strtoupper"],
			"pascal"=> ["pattern"=>"/[A-Z]/", "adjust"=>""],
			"snake"=> ["pattern"=>"/_[\w]/", "adjust"=>"_", 
				"adjustFunction"=>"strtolower"],
			"kebab"=> ["pattern"=>"/-[\w]/", "adjust"=>""],
			"phrase"=> ["pattern"=>"/\s./", "adjust"=>""]
		];

		$patternIn = $patterns[$caseIn];
		$patternTo = $patterns[$toCase];

		if ($caseIn == "phrase") {
			$str = strtolower($str);
		}

		$result = preg_replace_callback(
			$patternIn["pattern"], 
			function ($matches) use ($patternTo) {
				if (isset($patternTo["adjustFunction"])) {
					$result = call_user_func($patternTo["adjustFunction"], 
						$matches[0]);
					return $patternTo["adjust"].$result;
				} else {
					return $patternTo["adjust"].$matches[0];
				}
			}, $str);

		$firstChar = substr($result, 0, 1);
		if ($firstChar == "_" || $firstChar == "-") {
			$result = substr($result, 1, strlen($result)-1);
		}

		return $result;
	}

	static function snakeToCamel($string) {
		$string_parts = explode("_", $string);
		$first_part = $string_parts[0];
		$string_parts = array_slice($string_parts, 1);
		$camelCase = "";
		foreach($string_parts as $part) {
			$camelCase .= ucfirst($part);
		}
		return $first_part . $camelCase;
	}

	// transforma em nome de classe
	static function camelCase($string) {
		$className = "";
 		foreach ($string as $part) {
 			$className .= ucfirst($part);
 		}
		return $className;
	}

	static function classCase($string) {
		// var_dump($string);
		$string_parts = explode("_", $string);
		$camelCase = "";
		foreach($string_parts as $part) {
			$camelCase .= ucfirst($part);
		}

		return $camelCase;
	}
}
