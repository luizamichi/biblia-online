<?php

require_once __DIR__ . "/../autoload.php";


/**
 * Classe ORM de versículos
 *
 * @category DAO
 */
class VersaoDAO extends DAO {
	/**
	 * @param object $linha
	 *
	 * @static
	 * @return Versao
	 */
	public static function associative(object $linha): Versao {
		$chave = $linha->versao_id ?? 0;
		$nome = $linha->versao_nome ?? "";
		$abreviado = $linha->versao_abreviado ?? "";

		return new Versao(
			is_int($chave) ? $chave : 0,
			is_string($nome) ? $nome : "",
			is_string($abreviado) ? $abreviado : ""
		);
	}


	/**
	 * @param int $chave
	 *
	 * @static
	 * @return ?Versao
	 */
	public static function chave(int $chave): ?Versao {
		$consulta = "SELECT `versao_id`, `versao_nome`, `versao_abreviado`
                       FROM `versoes`
                      WHERE `versao_id` = :versao_id;";
		$parametros = [[":versao_id", $chave, PDO::PARAM_INT]];

		return parent::fetch($consulta, $parametros, function(object $linha): Versao {
			return self::associative($linha);
		});
	}


	/**
	 * @param string $nome
	 *
	 * @static
	 * @return ?Versao
	 */
	public static function nome(string $nome): ?Versao {
		$consulta = "SELECT `versao_id`, `versao_nome`, `versao_abreviado`
                       FROM `versoes`
                      WHERE `versao_nome` = :versao_nome;";
		$parametros = [[":versao_nome", $nome, PDO::PARAM_STR]];

		return parent::fetch($consulta, $parametros, function(object $linha): Versao {
			return self::associative($linha);
		});
	}


	/**
	 * @param string $abreviado
	 *
	 * @static
	 * @return ?Versao
	 */
	public static function abreviado(string $abreviado): ?Versao {
		$consulta = "SELECT `versao_id`, `versao_nome`, `versao_abreviado`
                       FROM `versoes`
                      WHERE `versao_abreviado` = :versao_abreviado;";
		$parametros = [[":versao_abreviado", $abreviado, PDO::PARAM_STR]];

		return parent::fetch($consulta, $parametros, function(object $linha): Versao {
			return self::associative($linha);
		});
	}


	/**
	 * @static
	 * @return array<Versao>
	 */
	public static function all(): array {
		$consulta = "SELECT `versao_id`, `versao_nome`, `versao_abreviado`
                       FROM `versoes`";

		return parent::fetchAll($consulta, [], function(object $linha): Versao {
			return self::associative($linha);
		});
	}


	/**
	 * @param Versao $versao
	 *
	 * @static
	 * @return bool
	 */
	public static function insert(Versao &$versao): bool {
		$consulta = "INSERT INTO `versoes` (`versao_nome`, `versao_abreviado`)
                     VALUES (:versao_nome, :versao_abreviado);";
		$parametros = [
			[":versao_nome", $versao->nome, PDO::PARAM_STR],
			[":versao_abreviado", $versao->abreviado, PDO::PARAM_STR]
		];

		$versao->chave = parent::post($consulta, $parametros);
		return $versao->chave > 0;
	}


	/**
	 * @param Versao $versao
	 *
	 * @static
	 * @return bool
	 */
	public static function update(Versao $versao): bool {
		$consulta = "UPDATE `versoes`
                        SET `versao_nome` = :versao_nome,
                            `versao_abreviado` = :versao_abreviado
                      WHERE `versao_id` = :versao_id;";
		$parametros = [
			[":versao_nome", $versao->nome, PDO::PARAM_STR],
			[":versao_abreviado", $versao->abreviado, PDO::PARAM_STR],
			[":versao_id", $versao->chave, PDO::PARAM_INT]
		];

		return parent::post($consulta, $parametros) > 0;
	}


	/**
	 * @param Versao $versao
	 *
	 * @static
	 * @return bool
	 */
	public static function delete(Versao $versao): bool {
		$consulta = "DELETE FROM `versoes`
                      WHERE `versao_id` = :versao_id;";
		$parametros = [[":versao_id", $versao->chave, PDO::PARAM_INT]];

		return parent::post($consulta, $parametros) > 0;
	}
}
