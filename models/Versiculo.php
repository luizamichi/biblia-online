<?php

require_once __DIR__ . "/../autoload.php";


/**
 * Classe entidade
 *
 * @category Model
 */
class Versiculo extends Modelo {
	public const TABELA = true;


	/**
	 * @param int $chave
	 * @param ?Versao $versao
	 * @param ?Livro $livro
	 * @param int $capitulo
	 * @param int $numero
	 * @param string $texto
	 *
	 * @return void
	 */
	public function __construct(private int $chave=0, private ?Versao $versao=null, private ?Livro $livro=null, private int $capitulo=0, private int $numero=0, private string $texto="") {
		$this->versao = $versao ?? (new Versao);
		$this->livro = $livro ?? (new Livro);
		parent::__construct($this);
	}


	/**
	 * @param string $atributo
	 * @param int|Livro|string|Versao $valor
	 *
	 * @return void
	 */
	public function __set(string $atributo, int|Livro|string|Versao $valor): void {
		if(in_array($atributo, ["chave", "versao", "livro", "capitulo", "numero", "texto"])) {
			$this->$atributo = $valor;
		}
	}


	/**
	 * @param string $atributo
	 *
	 * @return array<int,ReflectionProperty>|int|Livro|null|string|Versao
	 */
	public function __get(string $atributo): array|int|Livro|null|string|Versao {
		return $this->$atributo ?? null;
	}
}
