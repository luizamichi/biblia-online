<?php

require_once(__DIR__ . "/../autoload.php");


/**
 * Classe controladora de erros
 */
class ErroController {
	/**
	 * @static
	 * @return ?array
	 */
	public static function last(): ?array {
		$erros = error_get_last();
		$configuracao = Configuracao::ini();

		if(!empty($erros) && !$configuracao::get("debug", "project")) {
			$configuracao::set("message", $erros["message"], "error");
			$configuracao::set("type", $erros["type"], "error");
			$configuracao::set("line", $erros["line"], "error");
			$configuracao::set("file", $erros["file"], "error");
			$configuracao->save();
		}
		return $erros;
	}
}
