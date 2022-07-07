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
	 * @param string $chaves
	 *
	 * @static
	 * @return void
	 */
	public static function unset(string ...$chaves): void {
		foreach($chaves as $chave) {
			unset($_SESSION[$chave]);
		}
	}


	/**
	 * @param string $chave
	 *
	 * @static
	 * @return mixed
	 */
	public static function get(string $chave): mixed {
		return $_SESSION[$chave] ?? null;
	}
}
