<?php

require_once __DIR__ . "/../daos/DAO.php";

class SubDAO extends DAO {
	public static function associative(object $linha) {
		return [
			"nome" => $linha->nome ?? "",
			"idade" => $linha->idade ?? 0
		];
	}

	public static function consulta() {
		$consulta = "SELECT 'Nome' nome, 30 idade;";
		return parent::fetch($consulta, [], function(object $linha) {
			return self::associative($linha);
		});
	}
}

$subDAO = SubDAO::consulta();
echo json_encode($subDAO, JSON_PRETTY_PRINT);
