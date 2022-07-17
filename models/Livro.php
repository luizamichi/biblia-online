<?php

require_once __DIR__ . "/../autoload.php";


/**
 * Classe entidade
 *
 * @category Model
 *
 * @property int $chave
 * @property ?Testamento $testamento
 * @property string $nome
 * @property string $abreviado
 * @property int $posicao
 * @property string $sobre
 * @property int $capitulos
 * @property array<Autor> $autores
 */
class Livro extends Modelo {
	public const TABELA = true;


	/**
	 * @param int $chave
	 * @param ?Testamento $testamento
	 * @param string $nome
	 * @param string $abreviado
	 * @param int $posicao
	 * @param ?string $sobre
	 * @param int $capitulos
	 * @param array<Autor> $autores
	 *
	 * @return void
	 */
	public function __construct(private int $chave=0, private ?Testamento $testamento=null, private string $nome="", private string $abreviado="", private int $posicao=0, private ?string $sobre="", private int $capitulos=0, private array $autores=[]) {
		$this->testamento = $testamento ?? (new Testamento);
		parent::__construct($this);
	}


	/**
	 * @param string $atributo
	 * @param array<Autor>|int|string|Testamento $valor
	 *
	 * @return void
	 */
	public function __set(string $atributo, array|int|string|Testamento $valor): void {
		if($atributo === "chave" && is_numeric($valor)) {
			$this->chave = (int) $valor;
		}
		elseif($atributo === "testamento" && $valor instanceof Testamento) {
			$this->testamento = $valor;
		}
		elseif($atributo === "autores" && is_array($valor)) {
			$this->autores = $valor;
		}
		elseif($atributo === "posicao" && is_numeric($valor)) {
			$this->posicao = (int) $valor;
		}
		elseif($atributo === "capitulos" && is_numeric($valor)) {
			$this->capitulos = (int) $valor;
		}
		else {
			$this->$atributo = $valor;
		}
	}


	/**
	 * @param string $atributo
	 *
	 * @return array<Autor>|int|null|string|Testamento
	 */
	public function __get(string $atributo): array|int|null|string|Testamento {
		$valor = null;

		if(property_exists($this, $atributo)) {
			/**
			 * @var array<Autor>|int|null|string|Testamento
			 */
			$valor = $this->$atributo;
		}

		return $valor;
	}
}
