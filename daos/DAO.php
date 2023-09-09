<?php

require_once __DIR__ . "/../autoload.php";


/**
 * Classe útil
 * @author Luiz Amichi <luizamichi@luizamichi.com>
 */
class DAO {
	/**
	 * @static
	 * @param string $consulta
	 * @param array $parametros
	 * @return object
	 */
	private static function map(string $consulta, array $parametros): object {
		$conexao = Conexao::get();
		$stmt = $conexao->prepare($consulta);

		foreach($parametros as $parametro) {
			$stmt->bindValue($parametro[0], $parametro[1], $parametro[2]);
		}

		$stmt->execute();
		return $stmt;
	}


	/**
	 * @static
	 * @param string $consulta
	 * @param array $parametros
	 * @param bool $unique
	 * @return array|null|object
	 */
	private static function query(string $consulta, array $parametros, bool $unique): array|null|object {
		$stmt = self::map($consulta, $parametros);
		return $unique ? ($stmt->rowCount() ? $stmt->fetch() : null) : $stmt->fetchAll();
	}


	/**
	 * @static
	 * @param string $consulta
	 * @param array $parametros
	 * @return bool
	 */
	public static function post(string $consulta, array $parametros=[]): bool {
		$stmt = self::map($consulta, $parametros);
		return $stmt->rowCount() > 0;
	}


	/**
	 * @static
	 * @param string $consulta
	 * @param array $parametros
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
	 * @static
	 * @param string $consulta
	 * @param array $parametros
	 * @param ?callable $funcao
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
	 * @static
	 * @param string $consulta
	 * @param array $parametros
	 * @param ?callable $funcao
	 * @return array
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
