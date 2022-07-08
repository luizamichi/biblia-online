<?php

require_once __DIR__ . "/../autoload.php";


/**
 * Classe entidade
 *
 * @category Model
 */
class Autor extends Modelo {
	public const TABELA = true;


	/**
	 * @param int $chave
	 * @param string $nome
	 * @param string $apelido
	 * @param ?string $sobre
	 *
	 * @return void
	 */
	public function __construct(private int $chave=0, private string $nome="", private string $apelido="", private ?string $sobre=null) {
		parent::__construct($this);
	}


	/**
	 * @param string $atributo
	 * @param int|string $valor
	 *
	 * @return void
	 */
	public function __set(string $atributo, int|string $valor): void {
		if(in_array($atributo, ["chave", "nome", "apelido", "sobre"])) {
			$this->$atributo = $valor;
		}
	}


	/**
	 * @param string $atributo
	 *
	 * @return array<int,ReflectionProperty>|int|null|string
	 */
	public function __get(string $atributo): array|int|null|string {
		return $this->$atributo ?? null;
	}
}
