<?php

require_once __DIR__ . "/../models/Conexao.php";

try {
	$conexao = new Conexao();
	echo "Conectado";
}
catch(PDOException $e) {
	echo "Erro ao conectar: " . $e->getMessage();
}
finally {
	$conexao = null;
}
