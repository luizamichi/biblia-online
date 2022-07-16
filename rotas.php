<?php

require_once __DIR__ . "/autoload.php";

$requisicao = (string) strtok($_SERVER["REQUEST_URI"] ?? "", "?");
$parametros = array_values(array_filter(explode("/", $requisicao)));
$direcionador = $parametros[0] ?? "";

try {
	Conexao::get();
}
catch(Throwable $th) {
	http_response_code(500);

	if($direcionador === "api") {
		header("Content-Type: application/json");
		exit(json_encode([
			"resultado" => null,
			"mensagem" => $th->getMessage(),
			"erro" => ErroController::last(),
			"sucesso" => false
		]));
	}
	else {
		exit;
	}
}

switch($direcionador) {
	// Realiza CRUD no banco de dados
	case "api":
		include_once __DIR__ . "/api.php";
		break;
	// Rota específica para login/logout
	case "login":
		include_once __DIR__ . "/login.php";
		break;
}
