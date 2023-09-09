<?php

/**
 * Classe template
 * @author Luiz Amichi <luizamichi@luizamichi.com>
 */
class Navegador {
	/**
	 * @var int $atual
	 * @var string $anterior
	 * @var string $proximo
	 */
	private int $atual;
	private string $anterior;
	private string $proximo;


	/**
	 * @param int $atual
	 * @param string $anterior
	 * @param string $proximo
	 * @return void
	 */
	public function __construct(int $atual=1, string $anterior="", string $proximo="") {
		$this->atual = $atual;
		$this->anterior = $anterior;
		$this->proximo = $proximo;
	}


	/**
	 * @param string $atributo
	 * @param int|string $valor
	 * @return void
	 */
	public function __set(string $atributo, int|string $valor): void {
		if(in_array($atributo, ["atual", "anterior", "proximo"])) {
			$this->$atributo = $valor;
		}
	}


	/**
	 * @param string $atributo
	 * @return int|null|string
	 */
	public function __get(string $atributo): int|null|string {
		return $this->$atributo ?? null;
	}
}
