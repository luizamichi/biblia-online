<?php

require_once __DIR__ . "/../autoload.php";


/**
 * Classe entidade
 * @author Luiz Amichi <luizamichi@luizamichi.com>
 */
class Biblia {
	/**
	 * @var Versao $versao
	 * @var array<Livro> $livros
	 */
	private Versao $versao;
	private array $livros;


	/**
	 * @param ?Versao $versao
	 * @param array<Livro> $livros
	 * @return void
	 */
	public function __construct(?Versao $versao=null, array $livros=[]) {
		$this->versao = $versao ?? (new Versao);
		$this->livros = $livros;
	}


	/**
	 * @param string $atributo
	 * @param array<Livro>|Versao $valor
	 * @return void
	 */
	public function __set(string $atributo, array|Versao $valor): void {
		if(in_array($atributo, ["versao", "livros"])) {
			$this->$atributo = $valor;
		}
	}


	/**
	 * @param string $atributo
	 * @return array<Livro>|null|Versao
	 */
	public function __get(string $atributo): array|null|Versao {
		return $this->$atributo ?? null;
	}
}
