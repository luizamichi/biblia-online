<?php

require_once __DIR__ . "/../autoload.php";


/**
 * Classe entidade
 */
class Livro extends Modelo {
	/**
	 * @var int $chave
	 * @var Testamento $testamento
	 * @var string $nome
	 * @var string $abreviado
	 * @var int $posicao
	 * @var string $sobre
	 * @var int $capitulos
	 * @var array<Autor> $autores
	 */
	private int $chave;
	private Testamento $testamento;
	private string $nome;
	private string $abreviado;
	private int $posicao;
	private string $sobre;
	private int $capitulos;
	private array $autores;


	/**
	 * @var bool TABELA
	 */
	public const TABELA = true;


	/**
	 * @param int $chave
	 * @param ?Testamento $testamento
	 * @param string $nome
	 * @param string $abreviado
	 * @param int $posicao
	 * @param string $sobre
	 * @param int $capitulos
	 * @param array<Autor> $autores
	 * @return void
	 */
	public function __construct(int $chave=0, ?Testamento $testamento=null, string $nome="", string $abreviado="", int $posicao=0, ?string $sobre="", int $capitulos=0, array $autores=[]) {
		$this->chave = $chave;
		$this->testamento = $testamento ?? (new Testamento);
		$this->nome = $nome;
		$this->abreviado = $abreviado;
		$this->posicao = $posicao;
		$this->sobre = $sobre ?? "";
		$this->capitulos = $capitulos;
		$this->autores = $autores;
		parent::__construct($this);
	}


	/**
	 * @param string $atributo
	 * @param array<Autor>|int|string|Testamento $valor
	 * @return void
	 */
	public function __set(string $atributo, array|int|string|Testamento $valor): void {
		if(in_array($atributo, ["chave", "testamento", "nome", "abreviado", "posicao", "sobre", "capitulos", "autores"])) {
			$this->$atributo = $valor;
		}
	}


	/**
	 * @param string $atributo
	 * @return array<Autor>|int|null|string|Testamento
	 */
	public function __get(string $atributo): array|int|null|string|Testamento {
		return $this->$atributo ?? null;
	}
}
