<?php

/**
 * Classe template
 * @author Luiz Amichi <luizamichi@luizamichi.com>
 */
class Alerta {
	/**
	 * @var string $titulo
	 * @var string $texto
	 */
	private string $titulo;
	private string $texto;


	/**
	 * @param string $titulo
	 * @param string $texto
	 * @return void
	 */
	public function __construct(string $titulo="", string $texto="") {
		$this->titulo = $titulo;
		$this->texto = $texto;
	}


	/**
	 * @param string $atributo
	 * @param string $valor
	 * @return void
	 */
	public function __set(string $atributo, string $valor): void {
		if(in_array($atributo, ["titulo", "texto"])) {
			$this->$atributo = $valor;
		}
	}


	/**
	 * @param string $atributo
	 * @return string
	 */
	public function __get(string $atributo): string {
		return $this->$atributo;
	}
}
