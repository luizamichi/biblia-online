<?php

require_once __DIR__ . "/../autoload.php";


/**
 * Classe entidade
 */
class Versiculo extends Modelo {
	/**
	 * @var int $chave
	 * @var Versao $versao
	 * @var Livro $livro
	 * @var int $capitulo
	 * @var int $numero
	 * @var string $texto
	 */
	private int $chave;
	private Versao $versao;
	private Livro $livro;
	private int $capitulo;
	private int $numero;
	private string $texto;


	/**
	 * @var bool TABELA
	 */
	public const TABELA = true;


	/**
	 * @param int $chave
	 * @param ?Versao $versao
	 * @param ?Livro $livro
	 * @param int $capitulo
	 * @param int $numero
	 * @param string $texto
	 * @return void
	 */
	public function __construct(int $chave=0, ?Versao $versao=null, ?Livro $livro=null, int $capitulo=0, int $numero=0, string $texto="") {
		$this->chave = $chave;
		$this->versao = $versao ?? (new Versao);
		$this->livro = $livro ?? (new Livro);
		$this->capitulo = $capitulo;
		$this->numero = $numero;
		$this->texto = $texto;
		parent::__construct($this);
	}


	/**
	 * @param string $atributo
	 * @param int|Livro|string|Versao $valor
	 * @return void
	 */
	public function __set(string $atributo, int|Livro|string|Versao $valor): void {
		if(in_array($atributo, ["chave", "versao", "livro", "capitulo", "numero", "texto"])) {
			$this->$atributo = $valor;
		}
	}


	/**
	 * @param string $atributo
	 * @return array|int|Livro|null|string|Versao
	 */
	public function __get(string $atributo): array|int|Livro|null|string|Versao {
		return $this->$atributo ?? null;
	}
}
