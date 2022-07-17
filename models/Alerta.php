<?php

/**
 * Classe template
 *
 * @category Model
 */
class Alerta {
	/**
	 * @param string $titulo
	 * @param string $texto
	 *
	 * @return void
	 */
	public function __construct(public string $titulo="", public string $texto="") {}
}
