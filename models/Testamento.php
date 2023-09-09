<?php

require_once __DIR__ . "/../autoload.php";


/**
 * Classe entidade
 * @author Luiz Amichi <luizamichi@luizamichi.com>
 */
class Testamento extends Modelo {
	/**
	 * @var int $chave
	 * @var string $nome
	 * @var string $abreviado
	 */
	private int $chave;
	private string $nome;
	private string $abreviado;


	/**
	 * @var bool TABELA
	 */
	public const TABELA = true;


	/**
	 * @param int $chave
	 * @param string $nome
	 * @param string $abreviado
	 * @return void
	 */
	public function __construct(int $chave=0, string $nome="", string $abreviado="") {
		$this->chave = $chave;
		$this->nome = $nome;
		$this->abreviado = $abreviado;
		parent::__construct($this);
	}


	/**
	 * @param string $atributo
	 * @param int|string $valor
	 * @return void
	 */
	public function __set(string $atributo, int|string $valor): void {
		if(in_array($atributo, ["chave", "nome", "abreviado"])) {
			$this->$atributo = $valor;
		}
	}


	/**
	 * @param string $atributo
	 * @return array|int|null|string
	 */
	public function __get(string $atributo): array|int|null|string {
		return $this->$atributo ?? null;
	}
}
