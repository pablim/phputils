<?php

namespace phputils;

use DateTime;

class Date {

	static function formataData($data) {
		if ($data != null) {
			$date = new DateTime($data);
			return $date->format('d/m/Y');
		}
	}

	static function diaSemana($data) {
		if ($data == "") 
			return "";

		return strtoupper(Util::removeAcentos(strftime("%a", strtotime($data))));
	}

	static function dataExtenso($data) {
		if ($data == "")
			return "";
		$dataExtenso = Util::datePatternFormat($data, 'd');
		$dataExtenso .= " " . strtoupper(strftime("%h", strtotime($data)));
		$dataExtenso .= " " . Util::datePatternFormat($data, 'Y');
		return $dataExtenso;
	}

	// Recebe uma string. Por padrão o formato é brasileiro
	static function datePatternFormat($data, $format="d/m/Y") {
		if ($data != null) {
			$date = new DateTime($data);
			return $date->format($format);
		}
	}

	static function formataDataDiaMes($data) {
		if ($data != null) {
			$date = new DateTime($data);
			return $date->format('d/m');
		}
	}

	// Calcula a diferença em dias entre duas datas
	static function dias($dataInicio, $dataFim) {
		// Calcula a diferença em segundos entre as datas
		$diferenca = strtotime($dataFim) - strtotime($dataInicio);

		//Calcula a diferença em dias
		$dias = floor($diferenca / (60 * 60 * 24));

		return intval($dias);
	}

	static function isDate($date, $format = 'Y-m-d') {
		$d = DateTime::createFromFormat($format, $date);
		// The Y ( 4 digits year ) returns TRUE for any integer with any number of digits so changing the comparison from == to === fixes the issue.
		return $d && $d->format($format) === $date;
	}

	static function sortDate($dateArray) {
		uksort($dateArray, function ($a, $b) {
				return strtotime($a) - strtotime($b);
			}
		);
		return $dateArray;
	}

	static function inicioFimMes($year, $month) {
		$dias_mes = cal_days_in_month(CAL_GREGORIAN, $month, $year);
		$inicio = date('Y-m-d', mktime(0, 0, 0, $month, 1, $year));
		$fim = date('Y-m-d', mktime(0, 0, 0, $month, $dias_mes, $year));

		return ["inicio"=>$inicio, "fim"=>$fim];
	}

}
