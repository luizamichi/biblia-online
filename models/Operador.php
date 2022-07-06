<?php

require_once __DIR__ . "/../autoload.php";

/**
 * Classe útil
 *
 * @category Model
 */
final class Operador {
	/**
	 * @return void
	 */
	public function __construct() {}


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
