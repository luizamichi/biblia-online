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
	 * @param array<int,array{0:int|string,1:mixed,2:int}> $parametros
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
	 * @param array<int,array{0:int|string,1:mixed,2:int}> $parametros
	 * @param bool $unique
	 *
	 * @static
	 * @return array<object>|null|object
	 */
	private static function query(string $consulta, array $parametros, bool $unique): array|null|object {
		$stmt = self::map($consulta, $parametros);

		if($unique) {
			/**
			 * @var false|object $resultado
			 */
			$resultado = $stmt->fetch();

			return $resultado !== false && $stmt->rowCount() ? $resultado : null;
		}
		else {
			/**
			 * @var array<object> $resultado
			 */
			$resultado = $stmt->fetchAll();
		}

		return $resultado;
	}


	/**
	 * @param string $consulta
	 * @param array<int,array{0:int|string,1:mixed,2:int}> $parametros
	 *
	 * @static
	 * @return int
	 */
	public static function post(string $consulta, array $parametros=[]): int {
		$stmt = self::map($consulta, $parametros);

		if($stmt->rowCount() > 0) {
			return ((int) Conexao::get()->lastInsertId()) ?: $stmt->rowCount();
		}

		return 0;
	}


	/**
	 * @param string $consulta
	 * @param array<array<int,array{0:int|string,1:mixed,2:int}>> $parametros
	 *
	 * @static
	 * @return bool
	 */
	public static function postAll(string $consulta, array $parametros=[]): bool {
		$response = false;

		foreach(explode(";", $consulta) as $subconsulta) {
			if(is_array(current($parametros))) {
				$stmt = self::map($subconsulta, current($parametros));
				$response = $response || ($stmt->rowCount() > 0);
				next($parametros);
			}
		}

		return $response;
	}


	/**
	 * @template T
	 *
	 * @param string $consulta
	 * @param array<int,array{0:int|string,1:mixed,2:int}> $parametros
	 * @param callable(object):T|null $funcao
	 *
	 * @static
	 * @return ($funcao is null ? object|null : T|null)
	 */
	public static function fetch(string $consulta, array $parametros=[], ?callable $funcao=null) {
		/**
		 * @var object|null $resultado
		 */
		$resultado = self::query($consulta, $parametros, true);

		if($resultado) {
			return $funcao ? $funcao($resultado) : $resultado;
		}
		else {
			return null;
		}
	}


	/**
	 * @template T
	 *
	 * @param string $consulta
	 * @param array<int,array{0:int|string,1:mixed,2:int}> $parametros
	 * @param callable(object):T|null $funcao
	 *
	 * @static
	 * @return ($funcao is null ? array<object> : array<T>)
	 */
	public static function fetchAll(string $consulta, array $parametros=[], ?callable $funcao=null): array {
		/**
		 * @var array<object> $resultado
		 */
		$resultado = self::query($consulta, $parametros, false);

		if($resultado) {
			return $funcao ? array_map($funcao, $resultado) : $resultado;
		}
		else {
			return [];
		}
	}
}
