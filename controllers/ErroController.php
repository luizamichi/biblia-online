<?php

require_once __DIR__ . "/../autoload.php";


/**
 * Classe controladora de erros
 *
 * @category Controller
 */
class ErroController {
	/**
	 * @static
	 * @return array{type:int,message:string,file:string,line:int}|null
	 */
	public static function last(): ?array {
		$erros = error_get_last();
		$configuracao = Configuracao::ini();

		if(!empty($erros) && !$configuracao::get("debug", "project")) {
			$configuracao::set("message", "\"" . $erros["message"] . "\"", "error");
			$configuracao::set("type", (string) $erros["type"], "error");
			$configuracao::set("line", (string) $erros["line"], "error");
			$configuracao::set("file", $erros["file"], "error");
			$configuracao->save();
		}

		return $erros;
	}


	/**
	 * @param Throwable $th
	 *
	 * @static
	 * @return array<string,mixed>
	 */
	public static function current(Throwable $th): array {
		return [
			"message" => $th->getMessage(),
			"type" => $th->getCode(),
			"line" => $th->getLine(),
			"file" => $th->getFile()
		];
	}
}
