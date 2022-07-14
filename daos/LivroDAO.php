<?php

require_once __DIR__ . "/../autoload.php";


/**
 * Classe ORM de versículos
 *
 * @category DAO
 */
class LivroDAO extends DAO {
	/**
	 * @param object $linha
	 *
	 * @static
	 * @return Livro
	 */
	public static function associative(object $linha): Livro {
		return new Livro(
			$linha->livro_id ?? null,
			TestamentoDAO::chave($linha->livro_testamento_id ?? null),
			$linha->livro_nome ?? null,
			$linha->livro_abreviado ?? null,
			$linha->livro_posicao ?? null,
			$linha->livro_sobre ?? null,
			$linha->livro_capitulos ?? null
		);
	}


	/**
	 * @param int $chave
	 *
	 * @static
	 * @return ?Livro
	 */
	public static function chave(int $chave): ?Livro {
		$consulta = "SELECT `livro_id`, `livro_testamento_id`, `livro_nome`, `livro_abreviado`, `livro_posicao`, `livro_sobre`, `livro_capitulos`
                       FROM `livros`
                      WHERE `livro_id` = :livro_id;";
		$parametros = [[":livro_id", $chave, PDO::PARAM_INT]];

		return parent::fetch($consulta, $parametros, function(object $linha): Livro {
			return self::associative($linha);
		});
	}


	/**
	 * @param string $abreviado
	 *
	 * @static
	 * @return ?Livro
	 */
	public static function abreviado(string $abreviado): ?Livro {
		$consulta = "SELECT `livro_id`, `livro_testamento_id`, `livro_nome`, `livro_abreviado`, `livro_posicao`, `livro_sobre`, `livro_capitulos`
                       FROM `livros`
                      WHERE `livro_abreviado` = :livro_abreviado;";
		$parametros = [[":livro_abreviado", $abreviado, PDO::PARAM_STR]];

		return parent::fetch($consulta, $parametros, function(object $linha): Livro {
			return self::associative($linha);
		});
	}


	/**
	 * @param int $autor
	 *
	 * @static
	 * @return array<Livro>
	 */
	public static function autor(int $autor): array {
		$consulta = "SELECT `livro_id`, `livro_testamento_id`, `livro_nome`, `livro_abreviado`, `livro_posicao`, `livro_sobre`, `livro_capitulos`
                       FROM `livros`
                      INNER JOIN `autores_livros`
                         ON `livro_id` = `autores_livros_livro_id`
                      WHERE `autores_livros_autor_id` = :autores_livros_autor_id;";
		$parametros = [[":autores_livros_autor_id", $autor, PDO::PARAM_INT]];

		return parent::fetchAll($consulta, $parametros, function(object $linha): Livro {
			return self::associative($linha);
		});
	}


	/**
	 * @param int $testamento
	 *
	 * @static
	 * @return array<Livro>
	 */
	public static function testamento(int $testamento): array {
		$consulta = "SELECT `livro_id`, `livro_testamento_id`, `livro_nome`, `livro_abreviado`, `livro_posicao`, `livro_sobre`, `livro_capitulos`
                       FROM `livros`
                      WHERE `livro_testamento_id` = :livro_testamento_id;";
		$parametros = [[":livro_testamento_id", $testamento, PDO::PARAM_INT]];

		return parent::fetchAll($consulta, $parametros, function(object $linha): Livro {
			return self::associative($linha);
		});
	}


	/**
	 * @static
	 * @return array<Livro>
	 */
	public static function all(): array {
		$consulta = "SELECT `livro_id`, `livro_testamento_id`, `livro_nome`, `livro_abreviado`, `livro_posicao`, `livro_sobre`, `livro_capitulos`
                       FROM `livros`;";
		return parent::fetchAll($consulta, [], function(object $linha): Livro {
			return self::associative($linha);
		});
	}


	/**
	 * @param Livro $livro
	 *
	 * @static
	 * @return bool
	 */
	public static function insert(Livro $livro): bool {
		$consulta = "INSERT INTO `livros` (`livro_testamento_id`, `livro_nome`, `livro_abreviado`, `livro_posicao`, `livro_sobre`, `livro_capitulos`)
                     VALUES (:livro_testamento_id, :livro_nome, :livro_abreviado, :livro_posicao, :livro_sobre, :livro_capitulos);";
		$parametros = [
			[":livro_testamento_id", $livro->testamento->chave, PDO::PARAM_INT],
			[":livro_nome", $livro->nome, PDO::PARAM_STR],
			[":livro_abreviado", $livro->abreviado, PDO::PARAM_STR],
			[":livro_posicao", $livro->posicao, PDO::PARAM_INT],
			[":livro_sobre", $livro->sobre, PDO::PARAM_STR],
			[":livro_capitulos", $livro->capitulos, PDO::PARAM_INT]
		];

		return parent::post($consulta, $parametros);
	}


	/**
	 * @param Livro $livro
	 *
	 * @static
	 * @return bool
	 */
	public static function update(Livro $livro): bool {
		$consulta = "UPDATE `livros`
                        SET `livro_testamento_id` = :livro_testamento_id,
                            `livro_nome` = :livro_nome,
                            `livro_abreviado` = :livro_abreviado,
                            `livro_posicao` = :livro_posicao,
                            `livro_sobre` = :livro_sobre,
                            `livro_capitulos` = :livro_capitulos
                      WHERE `livro_id` = :livro_id;";
		$parametros = [
			[":livro_testamento_id", $livro->testamento->chave, PDO::PARAM_INT],
			[":livro_nome", $livro->nome, PDO::PARAM_STR],
			[":livro_abreviado", $livro->abreviado, PDO::PARAM_STR],
			[":livro_posicao", $livro->posicao, PDO::PARAM_INT],
			[":livro_sobre", $livro->sobre, PDO::PARAM_STR],
			[":livro_capitulos", $livro->capitulos, PDO::PARAM_INT],
			[":livro_id", $livro->chave, PDO::PARAM_INT]
		];

		return parent::post($consulta, $parametros);
	}


	/**
	 * @param Livro $livro
	 *
	 * @static
	 * @return bool
	 */
	public static function delete(Livro $livro): bool {
		$consulta = "DELETE FROM `livros`
                      WHERE `livro_id` = :livro_id;";
		$parametros = [[":livro_id", $livro->chave, PDO::PARAM_INT]];

		return parent::post($consulta, $parametros);
	}
}
