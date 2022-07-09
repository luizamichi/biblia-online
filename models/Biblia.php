<?php

require_once __DIR__ . "/../autoload.php";


/**
 * Classe entidade
 *
 * @category Model
 *
 * @property ?Versao $versao
 * @property array<Livro> $livros
 */
class Biblia {
	/**
	 * @param ?Versao $versao
	 * @param array<Livro> $livros
	 *
	 * @return void
	 */
	public function __construct(private ?Versao $versao=null, private array $livros=[]) {
		$this->versao = $versao ?? (new Versao);
		$this->livros = $livros;
	}


	/**
	 * @param string $atributo
	 * @param array<Livro>|Versao $valor
	 *
	 * @return void
	 */
	public function __set(string $atributo, array|Versao $valor): void {
		if($atributo === "versao" && $valor instanceof Versao) {
			$this->versao = $valor;
		}
		elseif($atributo === "livros" && is_array($valor)) {
			$this->livros = $valor;
		}
		else {
			$this->$atributo = $valor;
		}
	}


	/**
	 * @param string $atributo
	 *
	 * @return array<Livro>|null|Versao
	 */
	public function __get(string $atributo): array|null|Versao {
		$valor = null;

		if(property_exists($this, $atributo)) {
			/**
			 * @var array<Livro>|null|Versao $valor
			 */
			$valor = $this->$atributo;
		}

		return $valor;
	}
}
