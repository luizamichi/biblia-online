<?php

require_once __DIR__ . "/../autoload.php";


/**
 * Classe entidade
 */
class Capitulo extends Modelo {
	/**
	 * @var int $numero
	 * @var array<Versiculo> $versiculos
	 */
	private int $numero;
	private array $versiculos;


	/**
	 * @param int $numero
	 * @param array<Versiculo> $versiculos
	 * @return void
	 */
	public function __construct(int $numero=0, array $versiculos=[]) {
		$this->numero = $numero;
		$this->versiculos = $versiculos;

		parent::__construct($this);
	}


	/**
	 * @param string $atributo
	 * @param array<Versiculo>|int $valor
	 * @return void
	 */
	public function __set(string $atributo, array|int $valor): void {
		if(in_array($atributo, ["numero", "versiculos"])) {
			$this->$atributo = $valor;
		}
	}


	/**
	 * @param string $atributo
	 * @return array<Versiculo>|int|null
	 */
	public function __get(string $atributo): array|int|null {
		return $this->$atributo ?? null;
	}
}
