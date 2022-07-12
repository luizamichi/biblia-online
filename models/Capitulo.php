<?php

require_once __DIR__ . "/../autoload.php";


/**
 * Classe entidade
 *
 * @category Model
 */
class Capitulo extends Modelo {
	/**
	 * @param int $numero
	 * @param array<Versiculo> $versiculos
	 *
	 * @return void
	 */
	public function __construct(private int $numero=0, private array $versiculos=[]) {
		parent::__construct($this);
	}


	/**
	 * @param string $atributo
	 * @param array<Versiculo>|int $valor
	 *
	 * @return void
	 */
	public function __set(string $atributo, array|int $valor): void {
		if(in_array($atributo, ["numero", "versiculos"])) {
			$this->$atributo = $valor;
		}
	}


	/**
	 * @param string $atributo
	 *
	 * @return array<Versiculo>|int|null
	 */
	public function __get(string $atributo): array|int|null {
		return $this->$atributo ?? null;
	}
}
