<?php

require_once __DIR__ . "/../autoload.php";


/**
 * Classe entidade
 *
 * @category Model
 *
 * @property int $chave
 * @property-read string $nome
 * @property-read string $abreviado
 */
class Testamento extends Modelo {
	public const TABELA = true;


	/**
	 * @param int $chave
	 * @param string $nome
	 * @param string $abreviado
	 *
	 * @return void
	 */
	public function __construct(private int $chave=0, private string $nome="", private string $abreviado="") {
		parent::__construct($this);
	}


	/**
	 * @param string $atributo
	 * @param int|string $valor
	 *
	 * @return void
	 */
	public function __set(string $atributo, int|string $valor): void {
		if($atributo === "chave" && is_numeric($valor)) {
			$this->chave = (int) $valor;
		}
		elseif(in_array($atributo, ["nome", "abreviado"])) {
			$this->$atributo = $valor;
		}
	}


	/**
	 * @param string $atributo
	 *
	 * @return array<int,ReflectionProperty>|int|null|string
	 */
	public function __get(string $atributo): array|int|null|string {
		$valor = null;

		if(property_exists($this, $atributo)) {
			/**
			 * @var int|null|string $valor
			 */
			$valor = $this->$atributo;
		}

		return $valor;
	}
}
