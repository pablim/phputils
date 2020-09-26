<?php

namespace utils;

use DateTime;
use \ReflectionException;

class phputils {

	static function response($status, $msgs=[], $results=[]) {
		$jsonText = json_encode([
			"status"=>$status,
			"msgs"=>$msgs,
			"result"=>$results
		]);

		echo $jsonText;
	}

	static function redirect($url, $status, $msgs, $results) {
		$status = htmlspecialchars($status);
		$status = urlencode($status);
		
		$msgsResp = json_encode($msgs, JSON_HEX_APOS);
		$msgsResp = htmlspecialchars($msgsResp);
		$msgsResp = urlencode($msgsResp);
		
		$resultsResp = json_encode($results, JSON_HEX_APOS);
		$resultsResp = htmlspecialchars($resultsResp);
		$resultsResp = urlencode($resultsResp);

		$data = "status=". $status 
			. "&msgs=" . $msgsResp
			. "&result=" . $resultsResp;

		header("Location: " . $url . "?" . $data);
		exit;
	}

	static function request($varName) {
		Util::verify($varName, $_REQUEST, "");
	}

	static function executeFunction($executeCommand, $params) {

		// var_dump($params);

		$entity = Util::classCase($executeCommand["entity"]);
		$function = $executeCommand["function"];
		extract($params,  EXTR_PREFIX_ALL, "execute");

		// var_dump(extract($params,  EXTR_PREFIX_INVALID, "pab"));


		// var_dump($entity.$posFix);
		$domain = "\\model\\dao\\".$entity;
		$instance = new $domain();
		// $function = $instance->$function;

		$result = call_user_func_array(
			array($instance,$function), $params);
		// $result = call_user_func_array("\\model\\dao\\".$entity."::".$function, $params);
		// $result = $instance->$function();
		// var_dump($instance);
		// var_dump($result);

		return $result;
	}

	static function shortClassName($object) {
		var_dump($object);
		$reflect = new \ReflectionClass($object);
		return $reflect->getShortName();
	}

}
