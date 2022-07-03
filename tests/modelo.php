<?php

require_once __DIR__ . "/../models/Modelo.php";

class Submodelo extends Modelo {
	private string $nome;

	public function __set($atributo, $valor) {
		$this->$atributo = $valor;
	}

	public function __get(string $atributo) {
		return $this?->$atributo;
	}
}

$submodelo = new Submodelo();
$submodelo->nome = "Teste";
$submodelo->idade = 29;

echo json_encode($submodelo->json(), JSON_PRETTY_PRINT);
