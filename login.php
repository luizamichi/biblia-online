<?php

require_once __DIR__ . "/autoload.php";
header("Content-Type: application/json");

$request = $_SERVER["REQUEST_METHOD"] ?? "POST";

// O método recebido é POST
if($request === "POST") {
	$username = trim((string) filter_input(INPUT_POST, "username", FILTER_UNSAFE_RAW, FILTER_DEFAULT));
	$password = trim((string) filter_input(INPUT_POST, "password", FILTER_UNSAFE_RAW, FILTER_DEFAULT));
	$logout = (int) trim((string) filter_input(INPUT_POST, "logout", FILTER_SANITIZE_NUMBER_INT, FILTER_DEFAULT));

	if($logout === 1) {
		if(Operador::logged()) {
			$mensagem = "Usuário desconectado com sucesso.";
		}

		Sessao::unset("username", "password");
	}
	else {
		Sessao::set("username", $username);
		Sessao::set("password", $password);
	}
}

$logado = Operador::logged();

http_response_code(200);
exit(json_encode([
	"resultado" => null,
	"mensagem" => $logado ? "Usuário autenticado com sucesso." : ($mensagem ?? "Usuário não autenticado, tente novamente."),
	"erro" => ErroController::last(),
	"sucesso" => $logado
]));
