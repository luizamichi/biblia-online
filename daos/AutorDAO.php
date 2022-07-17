<?php

require_once __DIR__ . "/../autoload.php";


/**
 * Classe ORM de autores
 *
 * @category DAO
 */
class AutorDAO extends DAO {
	/**
	 * @param object $linha
	 *
	 * @static
	 * @return Autor
	 */
	public static function associative(object $linha): Autor {
		$chave = $linha->autor_id ?? 0;
		$nome = $linha->autor_nome ?? "";
		$apelido = $linha->autor_apelido ?? "";
		$sobre = $linha->autor_sobre ?? null;

		return new Autor(
			is_int($chave) ? $chave : 0,
			is_string($nome) ? $nome : "",
			is_string($apelido) ? $apelido : "",
			is_string($sobre) ? $sobre : null
		);
	}


	/**
	 * @param int $chave
	 *
	 * @static
	 * @return ?Autor
	 */
	public static function chave(int $chave): ?Autor {
		$consulta = "SELECT `autor_id`, `autor_nome`, `autor_apelido`, `autor_sobre`
                       FROM `autores`
                      WHERE `autor_id` = :autor_id;";
		$parametros = [[":autor_id", $chave, PDO::PARAM_INT]];

		return parent::fetch($consulta, $parametros, function(object $linha): Autor {
			return self::associative($linha);
		});
	}


	/**
	 * @param string $apelido
	 *
	 * @static
	 * @return ?Autor
	 */
	public static function apelido(string $apelido): ?Autor {
		$consulta = "SELECT `autor_id`, `autor_nome`, `autor_apelido`, `autor_sobre`
                       FROM `autores`
                      WHERE `autor_apelido` = :autor_apelido;";
		$parametros = [[":autor_apelido", $apelido, PDO::PARAM_STR]];

		return parent::fetch($consulta, $parametros, function(object $linha): Autor {
			return self::associative($linha);
		});
	}


	/**
	 * @param int $livro
	 *
	 * @static
	 * @return array<Autor>
	 */
	public static function livro(int $livro): array {
		$consulta = "SELECT `autor_id`, `autor_nome`, `autor_apelido`, `autor_sobre`
                       FROM `autores`
                      INNER JOIN `autores_livros`
                         ON `autor_id` = `autores_livros_autor_id`
                      WHERE `autores_livros_livro_id` = :autores_livros_livro_id;";
		$parametros = [[":autores_livros_livro_id", $livro, PDO::PARAM_INT]];

		return parent::fetchAll($consulta, $parametros, function(object $linha): Autor {
			return self::associative($linha);
		});
	}


	/**
	 * @static
	 * @return array<Autor>
	 */
	public static function all(): array {
		$consulta = "SELECT `autor_id`, `autor_nome`, `autor_apelido`, `autor_sobre`
                       FROM `autores`;";
		return parent::fetchAll($consulta, [], function(object $linha): Autor {
			return self::associative($linha);
		});
	}


	/**
	 * @param Autor $autor
	 *
	 * @static
	 * @return bool
	 */
	public static function insert(Autor &$autor): bool {
		$consulta = "INSERT INTO `autores` (`autor_nome`, `autor_apelido`, `autor_sobre`)
                     VALUES (:autor_nome, :autor_apelido, :autor_sobre);";
		$parametros = [
			[":autor_nome", $autor->nome, PDO::PARAM_STR],
			[":autor_apelido", $autor->apelido, PDO::PARAM_STR],
			[":autor_sobre", $autor->sobre, PDO::PARAM_STR]
		];

		$autor->chave = parent::post($consulta, $parametros);
		return $autor->chave > 0;
	}


	/**
	 * @param Autor $autor
	 *
	 * @static
	 * @return bool
	 */
	public static function update(Autor $autor): bool {
		$consulta = "UPDATE `autores`
                        SET `autor_nome` = :autor_nome,
                            `autor_apelido` = :autor_apelido,
                            `autor_sobre` = :autor_sobre
                      WHERE `autor_id` = :autor_id;";
		$parametros = [
			[":autor_nome", $autor->nome, PDO::PARAM_STR],
			[":autor_apelido", $autor->apelido, PDO::PARAM_STR],
			[":autor_sobre", $autor->sobre, PDO::PARAM_STR],
			[":autor_id", $autor->chave, PDO::PARAM_INT]
		];

		return parent::post($consulta, $parametros) > 0;
	}


	/**
	 * @param Autor $autor
	 *
	 * @static
	 * @return bool
	 */
	public static function delete(Autor $autor): bool {
		$consulta = "DELETE FROM `autores`
                      WHERE `autor_id` = :autor_id";
		$parametros = [[":autor_id", $autor->chave, PDO::PARAM_INT]];

		return parent::post($consulta, $parametros) > 0;
	}
}
