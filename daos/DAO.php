<?php

require_once __DIR__ . "/../autoload.php";


/**
 * Classe útil
 *
 * @category DAO
 */
class DAO {
	/**
	 * @param string $consulta
	 * @param array<array<int|mixed|string>> $parametros
	 *
	 * @static
	 * @return PDOStatement
	 */
	private static function map(string $consulta, array $parametros): PDOStatement {
		$conexao = Conexao::get();
		$stmt = $conexao->prepare($consulta);

		foreach($parametros as $parametro) {
			$stmt->bindValue($parametro[0], $parametro[1], $parametro[2]);
		}

		$stmt->execute();
		return $stmt;
	}


	/**
	 * @param string $consulta
	 * @param array<array<int|mixed|string>> $parametros
	 * @param bool $unique
	 *
	 * @static
	 * @return array<object>|null|object
	 */
	private static function query(string $consulta, array $parametros, bool $unique): array|null|object {
		$stmt = self::map($consulta, $parametros);

		if($unique) {
			return $stmt->rowCount() ? $stmt->fetch() : null;
		}
		return $stmt->fetchAll();
	}


	/**
	 * @param string $consulta
	 * @param array<array<int|mixed|string>> $parametros
	 *
	 * @static
	 * @return bool
	 */
	public static function post(string $consulta, array $parametros=[]): bool {
		$stmt = self::map($consulta, $parametros);
		return $stmt->rowCount() > 0;
	}


	/**
	 * @param string $consulta
	 * @param array<array<int|mixed|string>> $parametros
	 *
	 * @static
	 * @return bool
	 */
	public static function postAll(string $consulta, array $parametros=[]): bool {
		$response = false;

		foreach(explode(";", $consulta) as $subconsulta) {
			if(is_array(current($parametros))) {
				$stmt = self::map($subconsulta, current($parametros));
				$response |= $stmt->rowCount() > 0;
				next($parametros);
			}
		}

		return $response;
	}


	/**
	 * @param string $consulta
	 * @param array<array<int|mixed|string>> $parametros
	 * @param ?callable $funcao
	 *
	 * @static
	 * @return ?object
	 */
	public static function fetch(string $consulta, array $parametros=[], ?callable $funcao=null): ?object {
		$resultado = self::query($consulta, $parametros, true);

		if($resultado) {
			return $funcao ? $funcao($resultado) : $resultado;
		}
		else {
			return null;
		}
	}


	/**
	 * @param string $consulta
	 * @param array<array<int|mixed|string>> $parametros
	 * @param ?callable $funcao
	 *
	 * @static
	 * @return array<Model|object>
	 */
	public static function fetchAll(string $consulta, array $parametros=[], ?callable $funcao=null): array {
		$resultado = self::query($consulta, $parametros, false);

		if($resultado) {
			return $funcao ? array_map($funcao, $resultado) : $resultado;
		}
		else {
			return [];
		}
	}
}
