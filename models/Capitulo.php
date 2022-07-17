<?php

require_once __DIR__ . "/../autoload.php";


/**
 * Classe entidade
 *
 * @category Model
 *
 * @property int $numero
 * @property array<Versiculo> $versiculos
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
		if($atributo === "numero" && is_numeric($valor)) {
			$this->numero = (int) $valor;
		}
		elseif($atributo === "versiculos" && is_array($valor)) {
			$this->versiculos = $valor;
		}
		else {
			$this->$atributo = $valor;
		}
	}


	/**
	 * @param string $atributo
	 *
	 * @return array<Versiculo>|int|null
	 */
	public function __get(string $atributo): array|int|null {
		$valor = null;

		if(property_exists($this, $atributo)) {
			/**
			 * @var array<Versiculo>|int|null
			 */
			$valor = $this->$atributo;
		}

		return $valor;
	}
}
