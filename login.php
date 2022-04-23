<?php

require_once(__DIR__ . "/autoload.php");
header("Content-Type: application/json");

$request = $_SERVER["REQUEST_METHOD"] ?? "POST";

// O metódo recebido é POST
if($request === "POST") {
	Sessao::set("username", trim(filter_input(INPUT_POST, "username", FILTER_UNSAFE_RAW, FILTER_DEFAULT)));
	Sessao::set("password", trim(filter_input(INPUT_POST, "password", FILTER_UNSAFE_RAW, FILTER_DEFAULT)));

	$logout = (int) trim(filter_input(INPUT_POST, "logout", FILTER_SANITIZE_NUMBER_INT, FILTER_DEFAULT) ?? "");
	if($logout === 1) {
		unset($_SESSION["username"], $_SESSION["password"]);
	}
}

$logado = Operador::logged();

http_response_code(200);
exit(json_encode([
	"resultado" => null,
	"mensagem" => $logado ? "Usuário autenticado com sucesso." : "Usuário não autenticado, tente novamente.",
	"erro" => ErroController::last(),
	"sucesso" => $logado
]));
