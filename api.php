<?php

require_once __DIR__ . "/autoload.php";
header("Content-Type: application/json");

$configuracao = Configuracao::ini();
$request = is_string($_SERVER["REQUEST_METHOD"] ?? null) ? $_SERVER["REQUEST_METHOD"] : "GET";

// O método recebido é GET
if($request === "GET") {
	// Não é possível realizar consulta no banco (parâmetro READ da sessão CRUD)
	if(!$configuracao::get("read", "crud")) {
		http_response_code(403);
		exit(json_encode([
			"resultado" => null,
			"mensagem" => "A leitura de dados está desabilitada.",
			"erro" => ErroController::last(),
			"sucesso" => false
		]));
	}

	exit("GET");
}


// O método recebido é POST
elseif($request === "POST") {
	// Não é possível realizar cadastro no banco (parâmetro INSERT da sessão CRUD)
	if(!$configuracao::get("insert", "crud")) {
		http_response_code(403);
		exit(json_encode([
			"resultado" => null,
			"mensagem" => "A inserção de dados está desabilitada.",
			"erro" => ErroController::last(),
			"sucesso" => false
		]));
	}

	exit("POST");
}


// O método recebido é PUT
elseif($request === "PUT") {
	// Não é possível realizar alteração no banco (parâmetro UPDATE da sessão CRUD)
	if(!$configuracao::get("update", "crud")) {
		http_response_code(403);
		exit(json_encode([
			"resultado" => null,
			"mensagem" => "A alteração de dados está desabilitada.",
			"erro" => ErroController::last(),
			"sucesso" => false
		]));
	}

	exit("PUT");
}


// O método recebido é DELETE
elseif($request === "DELETE") {
	// Não é possível realizar remoção no banco (parâmetro DELETE da sessão CRUD)
	if(!$configuracao::get("delete", "crud")) {
		http_response_code(403);
		exit(json_encode([
			"resultado" => null,
			"mensagem" => "A remoção de dados está desabilitada.",
			"erro" => ErroController::last(),
			"sucesso" => false
		]));
	}

	exit("DELETE");
}


// O método recebido é diferente de GET, POST, PUT ou DELETE
else {
	http_response_code(405);
	exit(json_encode([
		"resultado" => null,
		"mensagem" => "O método necessário para o envio deve ser GET, POST, PUT ou DELETE. " . $request . " não é permitido.",
		"erro" => ErroController::last(),
		"sucesso" => false
	]));
}
