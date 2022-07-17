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


	/**
	 * @static
	 * @return array<string>
	 */
	public static function autores(): array {
		if(!isset($_SESSION["autores"]) || empty($_SESSION["autores"])) {
			$_SESSION["autores"] = array_map(function(Autor $autor): string {
				return strtoupper($autor->apelido);
			}, AutorDAO::all());
		}

		/**
		 * @var array<string>
		 */
		return $_SESSION["autores"];
	}


	/**
	 * @static
	 * @return array<string>
	 */
	public static function livros(): array {
		if(!isset($_SESSION["livros"]) || empty($_SESSION["livros"])) {
			$_SESSION["livros"] = array_map(function(Livro $livro): string {
				return strtoupper($livro->abreviado);
			}, LivroDAO::all());
		}

		/**
		 * @var array<string>
		 */
		return $_SESSION["livros"];
	}


	/**
	 * @static
	 * @return array<string>
	 */
	public static function testamentos(): array {
		if(!isset($_SESSION["testamentos"]) || empty($_SESSION["testamentos"])) {
			$_SESSION["testamentos"] = array_map(function(Testamento $testamento): string {
				return strtoupper($testamento->abreviado);
			}, TestamentoDAO::all());
		}

		/**
		 * @var array<string>
		 */
		return $_SESSION["testamentos"];
	}


	/**
	 * @static
	 * @return array<string>
	 */
	public static function versoes(): array {
		if(!isset($_SESSION["versoes"]) || empty($_SESSION["versoes"])) {
			$_SESSION["versoes"] = array_map(function(Versao $versao): string {
				return strtoupper($versao->abreviado);
			}, VersaoDAO::all());
		}

		/**
		 * @var array<string>
		 */
		return $_SESSION["versoes"];
	}
}
