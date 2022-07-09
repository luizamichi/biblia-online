<?php

/**
 * Classe template
 *
 * @category Model
 *
 * @property string $titulo
 * @property ?string $descricao
 * @property ?string $local
 * @property ?int $codigo
 * @property ?int $linha
 * @property ?Versiculo $versiculoAleatorio
 * @property ?Versiculo $versiculoDiario
 * @property ?Versiculo $versiculoSemanal
 * @property ?Versiculo $versiculoMensal
 * @property ?Autor $autor
 * @property array<Livro> $livros
 * @property array<Autor> $autores
 * @property ?Livro $livro
 * @property ?Capitulo $capitulo
 * @property Versiculo $versiculo
 * @property ?Testamento $testamento
 * @property array<Testamento> $testamentos
 * @property ?Versao $versao
 * @property array<Versao> $versoes
 */
class Template {
	/**
	 * @var string $arquivo
	 */
	private string $arquivo;

	/**
	 * @var array<string,mixed> $variaveis
	 */
	private array $variaveis;


	/**
	 * @param string $arquivo
	 * @param array<string,mixed> $variaveis
	 *
	 * @return void
	 */
	public function __construct(string $arquivo="", array $variaveis=[]) {
		$this->arquivo = $arquivo;
		$this->variaveis = $variaveis;
	}


	/**
	 * @return void
	 */
	public function body(): void {
		include_once __DIR__ . "/../templates/cabecalho.php";
		include_once __DIR__ . "/../templates/menu.php";
		include_once __DIR__ . "/../templates/alerta.php";

		$this->html();

		include_once __DIR__ . "/../templates/login.html";
		include_once __DIR__ . "/../templates/rodape.html";
	}


	/**
	 * @return void
	 */
	public function body2(): void {
		include __DIR__ . "/../templates/cabecalho.php";

		$this->html();

		include_once __DIR__ . "/../templates/rodape.html";
	}


	/**
	 * @return void
	 */
	public function html(): void {
		foreach($this->variaveis as $chave => $valor) {
			${$chave} = $valor;
		}

		if(file_exists(__DIR__ . "/../templates/" . $this->arquivo . ".php")) {
			include_once __DIR__ . "/../templates/" . $this->arquivo . ".php";
		}
		elseif(file_exists(__DIR__ . "/../templates/" . $this->arquivo . ".html")) {
			include_once __DIR__ . "/../templates/" . $this->arquivo . ".html";
		}
	}


	/**
	 * @param string $atributo
	 * @param mixed $valor
	 *
	 * @return void
	 */
	public function __set(string $atributo, mixed $valor): void {
		if($atributo === "arquivo" && is_string($valor)) {
			$this->arquivo = $valor;
		}
		elseif($atributo === "variaveis" && is_array($valor)) {
			/**
			 * @var array<string,mixed>
			 */
			$variaveis = [];
			foreach($valor as $chave => $item) {
				if(is_string($chave)) {
					$variaveis[$chave] = $item;
				}
			}
			$this->variaveis = $variaveis;
		}
		else {
			$this->variaveis[$atributo] = $valor;
		}
	}


	/**
	 * @param string $atributo
	 *
	 * @return mixed
	 */
	public function __get(string $atributo): mixed {
		return $this->$atributo;
	}
}
