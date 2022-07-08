<?php

require_once __DIR__ . "/../autoload.php";


/**
 * Classe controladora de rotas
 *
 * @category Controller
 */
class RotaController {
	/**
	 * @static
	 * @return void
	 */
	public static function api(): void {
		include_once __DIR__ . "/../api.php";
	}


	/**
	 * @static
	 * @return void
	 */
	public static function login(): void {
		include_once __DIR__ . "/../login.php";
	}


	/**
	 * @param ?Throwable $excecao
	 *
	 * @static
	 * @return void
	 */
	public static function erro(?Throwable $excecao=null): void {
		$erro = ErroController::last();
		$template = new Template("erro");

		$template->descricao = $excecao?->getMessage() ?? $erro["message"] ?? "";
		$template->codigo = $excecao?->getCode() ?? $erro["type"] ?? 0;
		$template->linha = $excecao?->getLine() ?? $erro["line"] ?? 0;
		$template->local = $excecao?->getFile() ?? $erro["file"] ?? "";

		$template->body2();
	}


	/**
	 * @param string $arquivo
	 *
	 * @static
	 * @return void
	 */
	public static function files(string $arquivo): void {
		$extensao = pathinfo($arquivo, PATHINFO_EXTENSION);
		switch($extensao) {
			case "png":
				header("Content-Type: image/png");
				break;
			case "js":
				header("Content-type: text/javascript");
				break;
			case "css":
				header("Content-Type: text/css");
				break;
			default:
				header("Content-Type: text/plain");
				break;
		}

		include_once $arquivo;
	}
}
