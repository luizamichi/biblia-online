<?php

require_once __DIR__ . "/../autoload.php";


/**
 * Classe ORM de testamentos
 * @author Luiz Amichi <luizamichi@luizamichi.com>
 */
class TestamentoDAO extends DAO {
	/**
	 * @static
	 * @param object $linha
	 * @return Testamento
	 */
	public static function associative(object $linha): Testamento {
		return new Testamento(
			$linha->testamento_id,
			$linha->testamento_nome,
			$linha->testamento_abreviado
		);
	}


	/**
	 * @static
	 * @param int $chave
	 * @return ?Testamento
	 */
	public static function chave(int $chave): ?Testamento {
		$consulta = "SELECT `testamento_id`, `testamento_nome`, `testamento_abreviado` FROM `testamentos` WHERE `testamento_id` = :testamento_id;";
		$parametros = [
			[":testamento_id", $chave, PDO::PARAM_INT]
		];

		return parent::fetch($consulta, $parametros, function(object $linha): Testamento {
			return self::associative($linha);
		});
	}


	/**
	 * @static
	 * @param string $nome
	 * @return ?Testamento
	 */
	public static function nome(string $nome): ?Testamento {
		$consulta = "SELECT `testamento_id`, `testamento_nome`, `testamento_abreviado` FROM `testamentos` WHERE `testamento_nome` = :testamento_nome;";
		$parametros = [
			[":testamento_nome", $nome, PDO::PARAM_STR]
		];

		return parent::fetch($consulta, $parametros, function(object $linha): Testamento {
			return self::associative($linha);
		});
	}


	/**
	 * @static
	 * @param string $abreviado
	 * @return ?Testamento
	 */
	public static function abreviado(string $abreviado): ?Testamento {
		$consulta = "SELECT `testamento_id`, `testamento_nome`, `testamento_abreviado` FROM `testamentos` WHERE `testamento_abreviado` = :testamento_abreviado;";
		$parametros = [
			[":testamento_abreviado", $abreviado, PDO::PARAM_STR]
		];

		return parent::fetch($consulta, $parametros, function(object $linha): Testamento {
			return self::associative($linha);
		});
	}


	/**
	 * @static
	 * @return array<Testamento>
	 */
	public static function all(): array {
		$consulta = "SELECT `testamento_id`, `testamento_nome`, `testamento_abreviado` FROM `testamentos`;";
		return parent::fetchAll($consulta, [], function(object $linha): Testamento {
			return self::associative($linha);
		});
	}


	/**
	 * @static
	 * @param Testamento $testamento
	 * @return bool
	 */
	public static function insert(Testamento $testamento): bool {
		$consulta = "INSERT INTO `testamentos` (`testamento_nome`, `testamento_abreviado` VALUES (:testamento_nome, :testamento_abreviado);";
		$parametros = [
			[":testamento_nome", $testamento->nome, PDO::PARAM_STR],
			[":testamento_abreviado", $testamento->abreviado, PDO::PARAM_STR]
		];

		return parent::post($consulta, $parametros);
	}


	/**
	 * @static
	 * @param Testamento $testamento
	 * @return bool
	 */
	public static function update(Testamento $testamento): bool {
		$consulta = "UPDATE `testamentos` SET `testamento_nome` = :testamento_nome, `testamento_abreviado` = :testamento_abreviado WHERE `testamento_id` = :testamento_id;";
		$parametros = [
			[":testamento_nome", $testamento->nome, PDO::PARAM_STR],
			[":testamento_abreviado", $testamento->abreviado, PDO::PARAM_STR],
			[":testamento_id", $testamento->chave, PDO::PARAM_INT]
		];

		return parent::post($consulta, $parametros);
	}


	/**
	 * @static
	 * @param int $chave
	 * @return bool
	 */
	public static function delete(int $chave): bool {
		$consulta = "DELETE FROM `testamentos` WHERE `testamento_id` = :testamento_id;";
		$parametros = [
			[":testamento_id", $chave, PDO::PARAM_INT]
		];

		return parent::post($consulta, $parametros);
	}
}
