<?php

require_once __DIR__ . "/../autoload.php";


/**
 * Classe entidade
 * @author Luiz Amichi <luizamichi@luizamichi.com>
 */
class Autor extends Modelo {
	/**
	 * @var int $chave
	 * @var string $nome
	 * @var string $apelido
	 * @var string $sobre
	 */
	private int $chave;
	private string $nome;
	private string $apelido;
	private string $sobre;


	/**
	 * @var bool TABELA
	 */
	public const TABELA = true;


	/**
	 * @param int $chave
	 * @param string $nome
	 * @param string $apelido
	 * @param string $sobre
	 * @return void
	 */
	public function __construct(int $chave=0, string $nome="", string $apelido="", ?string $sobre="") {
		$this->chave = $chave;
		$this->nome = $nome;
		$this->apelido = $apelido;
		$this->sobre = $sobre ?? "";
		parent::__construct($this);
	}


	/**
	 * @param string $atributo
	 * @param int|string $valor
	 * @return void
	 */
	public function __set(string $atributo, int|string $valor): void {
		if(in_array($atributo, ["chave", "nome", "apelido", "sobre"])) {
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
