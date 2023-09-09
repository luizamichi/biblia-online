<?php

require_once __DIR__ . "/../autoload.php";


/**
 * Classe útil
 * @author Luiz Amichi <luizamichi@luizamichi.com>
 */
class Sessao {
	/**
	 * @static
	 * @param string $chave
	 * @param mixed $valor
	 * @return void
	 */
	public static function set(string $chave, mixed $valor): void {
		$_SESSION[$chave] = $valor;
	}


	/**
	 * @static
	 * @return mixed
	 */
	public static function get(mixed $chave): mixed {
		return $_SESSION[$chave] ?? null;
	}


	/**
	 * @static
	 * @return array<Autor>
	 */
	public static function autores(): array {
		if(!isset($_SESSION["autores"]) || empty($_SESSION["autores"])) {
			$_SESSION["autores"] = array_map(function(Autor $autor): string {
				return strtoupper($autor->apelido);
			}, AutorDAO::all());
		}

		return $_SESSION["autores"] ?? [];
	}


	/**
	 * @static
	 * @return array<Livro>
	 */
	public static function livros(): array {
		if(!isset($_SESSION["livros"]) || empty($_SESSION["livros"])) {
			$_SESSION["livros"] = array_map(function(Livro $livro): string {
				return strtoupper($livro->abreviado);
			}, LivroDAO::all());
		}

		return $_SESSION["livros"] ?? [];
	}


	/**
	 * @static
	 * @return array<Testamento>
	 */
	public static function testamentos(): array {
		if(!isset($_SESSION["testamentos"]) || empty($_SESSION["testamentos"])) {
			$_SESSION["testamentos"] = array_map(function(Testamento $testamento): string {
				return strtoupper($testamento->abreviado);
			}, TestamentoDAO::all());
		}

		return $_SESSION["testamentos"] ?? [];
	}


	/**
	 * @static
	 * @return array<Versao>
	 */
	public static function versoes(): array {
		if(!isset($_SESSION["versoes"]) || empty($_SESSION["versoes"])) {
			$_SESSION["versoes"] = array_map(function(Versao $versao): string {
				return strtoupper($versao->abreviado);
			}, VersaoDAO::all());
		}

		return $_SESSION["versoes"] ?? [];
	}
}
