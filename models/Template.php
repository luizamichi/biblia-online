<?php

/**
 * Classe template
 * @author Luiz Amichi <luizamichi@luizamichi.com>
 */
class Template {
	/**
	 * @var string $arquivo
	 * @var array $variaveis
	 */
	private string $arquivo;
	private array $variaveis;


	/**
	 * @param string $arquivo
	 * @param array $variaveis
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
		${"operador"} = new Operador();
		require_once __DIR__ . "/../templates/cabecalho.php";
		require_once __DIR__ . "/../templates/menu.php";
		require_once __DIR__ . "/../templates/alerta.php";

		$this->html();

		require_once __DIR__ . "/../templates/login.html";
		require_once __DIR__ . "/../templates/rodape.html";
	}


	/**
	 * @return void
	 */
	public function body2(): void {
		require_once __DIR__ . "/../templates/cabecalho.php";

		$this->html();

		require_once __DIR__ . "/../templates/rodape.html";
	}


	/**
	 * @return void
	 */
	public function html(): void {
		foreach($this->variaveis as $chave => $valor) {
			${$chave} = $valor;
		}

		if(file_exists(__DIR__ . "/../templates/" . $this->arquivo . ".php")) {
			require_once __DIR__ . "/../templates/" . $this->arquivo . ".php";
		}
		elseif(file_exists(__DIR__ . "/../templates/" . $this->arquivo . ".html")) {
			require_once __DIR__ . "/../templates/" . $this->arquivo . ".html";
		}
	}


	/**
	 * @param string $atributo
	 * @param mixed $valor
	 * @return void
	 */
	public function __set(string $atributo, mixed $valor): void {
		if(in_array($atributo, ["arquivo", "variaveis"])) {
			$this->$atributo = $valor;
		}
		else {
			$this->variaveis[$atributo] = $valor;
		}
	}


	/**
	 * @param string $atributo
	 * @return string
	 */
	public function __get(string $atributo): string {
		return $this->$atributo;
	}
}
