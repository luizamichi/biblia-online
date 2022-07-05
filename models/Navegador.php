<?php

/**
 * Classe template
 *
 * @category Model
 */
class Navegador {
	/**
	 * @param int $atual
	 * @param string $anterior
	 * @param string $proximo
	 *
	 * @return void
	 */
	public function __construct(public int $atual=1, public string $anterior="", public string $proximo="") {
		$this->atual = $atual;
		$this->anterior = $anterior;
		$this->proximo = $proximo;
	}
}
