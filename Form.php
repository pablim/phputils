<?php

namespace phputils;

class Form {

	function validaCampos($objeto) {

		$nomeClasse = shortClassName($objeto);
		var_dump($nomeClasse);
		$properties = properties($nomeClasse);

		foreach ($objeto as $campo => $valor) {
			var_dump($campo);

		}

	}

}
