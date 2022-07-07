<?php

require_once __DIR__ . "/../autoload.php";


/**
 * Classe útil para manipulação de sessões
 *
 * @category Model
 */
class Sessao {
	/**
	 * @param string $chave
	 * @param mixed $valor
	 *
	 * @static
	 * @return void
	 */
	public static function set(string $chave, mixed $valor): void {
		$_SESSION[$chave] = $valor;
	}


	/**
	 * @param mixed $chave
	 *
	 * @static
	 * @return mixed
	 */
	public static function get(mixed $chave): mixed {
		return $_SESSION[$chave] ?? null;
	}
}
