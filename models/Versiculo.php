<?php

require_once __DIR__ . "/../autoload.php";


/**
 * Classe entidade
 *
 * @category Model
 *
 * @property int $chave
 * @property ?Versao $versao
 * @property ?Livro $livro
 * @property int $capitulo
 * @property int $numero
 * @property string $texto
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
		if($atributo === "chave" && is_numeric($valor)) {
			$this->chave = (int) $valor;
		}
		elseif($atributo === "versao" && $valor instanceof Versao) {
			$this->versao = $valor;
		}
		elseif($atributo === "livro" && $valor instanceof Livro) {
			$this->livro = $valor;
		}
		elseif($atributo === "capitulo" && is_numeric($valor)) {
			$this->capitulo = (int) $valor;
		}
		elseif($atributo === "numero" && is_numeric($valor)) {
			$this->numero = (int) $valor;
		}
		elseif($atributo === "texto" && is_string($valor)) {
			$this->texto = $valor;
		}
		else {
			$this->$atributo = $valor;
		}
	}


	/**
	 * @param string $atributo
	 *
	 * @return array<int,ReflectionProperty>|int|Livro|null|string|Versao
	 */
	public function __get(string $atributo): array|int|Livro|null|string|Versao {
		$valor = null;

		if(property_exists($this, $atributo)) {
			/**
			 * @var int|Livro|null|string|Versao
			 */
			$valor = $this->$atributo;
		}

		return $valor;
	}
}
