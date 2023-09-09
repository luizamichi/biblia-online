<?php

require_once __DIR__ . "/../autoload.php";


/**
 * Classe útil
 * @author Luiz Amichi <luizamichi@luizamichi.com>
 * @final
 */
final class Operador {
	/**
	 * @var string $login
	 * @var string $senha
	 */
	private string $login;
	private string $senha;


	/**
	 * @param string $login
	 * @param string $senha
	 * @return void
	 */
	public function __construct(string $login="", string $senha="") {
		$this->login = $login;
		$this->senha = $senha;
	}


	/**
	 * @param string $atributo
	 * @param string $valor
	 * @return void
	 */
	public function __set(string $atributo, string $valor): void {
		if(in_array($atributo, ["login", "senha"])) {
			$this->$atributo = $valor;
		}
	}


	/**
	 * @param string $atributo
	 * @return string
	 */
	public function __get(string $atributo): string {
		return $this->$atributo;
	}


	/**
	 * @static
	 * @return bool
	 */
	public static function logged(): bool {
		$configuracao = Configuracao::ini();
		return $configuracao::get("username", "project") === (Sessao::get("username"))
			&& $configuracao::get("password", "project") === (Sessao::get("password"));
	}
}
