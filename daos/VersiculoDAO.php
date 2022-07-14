<?php

require_once __DIR__ . "/../autoload.php";


/**
 * Classe ORM de versículos
 *
 * @category DAO
 */
class VersiculoDAO extends DAO {
	/**
	 * @param object $linha
	 *
	 * @static
	 * @return Versiculo
	 */
	public static function associative(object $linha): Versiculo {
		return new Versiculo(
			$linha->versiculo_id ?? null,
			VersaoDAO::chave($linha->versiculo_versao_id ?? null),
			LivroDAO::chave($linha->versiculo_livro_id ?? null),
			$linha->versiculo_capitulo ?? null,
			$linha->versiculo_numero ?? null,
			$linha->versiculo_texto ?? null
		);
	}


	/**
	 * @param int $chave
	 *
	 * @static
	 * @return ?Versiculo
	 */
	public static function chave(int $chave): ?Versiculo {
		$consulta = "SELECT `versiculo_id`, `versiculo_versao_id`, `versiculo_livro_id`, `versiculo_capitulo`, `versiculo_numero`, `versiculo_texto`
                       FROM `versiculos`
                      WHERE `versiculo_id` = :versiculo_id;";
		$parametros = [[":versiculo_id", $chave, PDO::PARAM_INT]];

		return parent::fetch($consulta, $parametros, function(object $linha): Versiculo {
			return self::associative($linha);
		});
	}


	/**
	 * @param int $versao
	 * @param int $livro
	 * @param int $capitulo
	 *
	 * @static
	 * @return array<Versiculo>
	 */
	public static function versaoLivroCapitulo(int $versao, int $livro, int $capitulo): array {
		$consulta = "SELECT `versiculo_id`, `versiculo_versao_id`, `versiculo_livro_id`, `versiculo_capitulo`, `versiculo_numero`, `versiculo_texto`
                       FROM `versiculos`
                      WHERE `versiculo_versao_id` = :versiculo_versao_id
                        AND `versiculo_livro_id` = :versiculo_livro_id
                        AND `versiculo_capitulo` = :versiculo_capitulo;";
		$parametros = [
			[":versiculo_versao_id", $versao, PDO::PARAM_INT],
			[":versiculo_livro_id", $livro, PDO::PARAM_INT],
			[":versiculo_capitulo", $capitulo, PDO::PARAM_INT]
		];

		return parent::fetchAll($consulta, $parametros, function(object $linha): Versiculo {
			return self::associative($linha);
		});
	}


	/**
	 * @param int $versao
	 * @param int $livro
	 * @param int $capitulo
	 * @param int $numero
	 *
	 * @static
	 * @return ?Versiculo
	 */
	public static function versaoLivroCapituloNumero(int $versao, int $livro, int $capitulo, int $numero): ?Versiculo {
		$consulta = "SELECT `versiculo_id`, `versiculo_versao_id`, `versiculo_livro_id`, `versiculo_capitulo`, `versiculo_numero`, `versiculo_texto`
                       FROM `versiculos`
                      WHERE `versiculo_versao_id` = :versiculo_versao_id
                        AND `versiculo_livro_id` = :versiculo_livro_id
                        AND `versiculo_capitulo` = :versiculo_capitulo
                        AND `versiculo_numero` = :versiculo_numero;";
		$parametros = [
			[":versiculo_versao_id", $versao, PDO::PARAM_INT],
			[":versiculo_livro_id", $livro, PDO::PARAM_INT],
			[":versiculo_capitulo", $capitulo, PDO::PARAM_INT],
			[":versiculo_numero", $numero, PDO::PARAM_INT]
		];

		return parent::fetch($consulta, $parametros, function(object $linha): Versiculo {
			return self::associative($linha);
		});
	}


	/**
	 * @static
	 * @return int
	 */
	public static function length(): int {
		$consulta = "SELECT COUNT(*) tamanho
		               FROM `versiculos`;";
		return parent::fetch($consulta)->tamanho ?? 0;
	}


	/**
	 * @param Versiculo $versiculo
	 *
	 * @static
	 * @return bool
	 */
	public static function update(Versiculo $versiculo): bool {
		$consulta = "UPDATE `versiculos`
                        SET `versiculo_versao_id` = :versiculo_versao_id,
                            `versiculo_livro_id` = :versiculo_livro_id,
                            `versiculo_capitulo` = :versiculo_capitulo,
                            `versiculo_numero` = :versiculo_numero,
                            `versiculo_texto` = :versiculo_texto
                      WHERE `versiculo_id` = :versiculo_id;";
		$parametros = [
			[":versiculo_versao_id", $versiculo->versao->chave, PDO::PARAM_INT],
			[":versiculo_livro_id", $versiculo->livro->chave, PDO::PARAM_INT],
			[":versiculo_capitulo", $versiculo->capitulo, PDO::PARAM_INT],
			[":versiculo_numero", $versiculo->numero, PDO::PARAM_INT],
			[":versiculo_texto", $versiculo->texto, PDO::PARAM_STR],
			[":versiculo_id", $versiculo->chave, PDO::PARAM_INT]
		];

		return parent::post($consulta, $parametros);
	}


	/**
	 * @param Versiculo $versiculo
	 *
	 * @static
	 * @return bool
	 */
	public static function delete(Versiculo $versiculo): bool {
		$consulta = "DELETE FROM `versiculos`
                      WHERE `versiculo_id` = :versiculo_id;";
		$parametros = [[":versiculo_id", $versiculo->chave, PDO::PARAM_INT]];

		return parent::post($consulta, $parametros);
	}
}
