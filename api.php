<?php

/**
 * Procedimento genérico para consulta e alteração de dados
 * @api
 */
require_once(__DIR__ . "/autoload.php");
header("Content-Type: application/json");

$configuracao = Configuracao::ini();
$request = $_SERVER["REQUEST_METHOD"] ?? "GET";

// O metódo recebido é GET
if($request === "GET") {
	// Não é possível realizar SELECT no banco (parâmetro READ da sessão CRUD)
	if(!$configuracao::get("read", "crud")) {
		http_response_code(403);
		exit(json_encode([
			"resultado" => null,
			"mensagem" => "A leitura de dados está desabilitada.",
			"erro" => ErroController::last(),
			"sucesso" => false
		]));
	}

	$classe = ucfirst(filter_input(INPUT_GET, "classe", FILTER_DEFAULT, FILTER_UNSAFE_RAW));
	$campo = filter_input(INPUT_GET, "campo", FILTER_DEFAULT, FILTER_UNSAFE_RAW);
	$consulta = filter_input(INPUT_GET, "consulta", FILTER_DEFAULT, FILTER_UNSAFE_RAW);
	$argumentos = filter_input(INPUT_GET, "consulta", FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);

	// Faz um match da consulta -> parâmetro de consulta, campo -> função da classe DAO
	if(method_exists($classe . "DAO", $campo)) {
		$resultado = is_array($argumentos)
		? call_user_func_array($classe . "DAO::" . $campo, $argumentos)
		: call_user_func($classe . "DAO::" . $campo, $consulta);

		$contem = ($resultado->chave ?? $resultado->numero ?? is_array($resultado) && count($resultado) ?? 0) > 0;
		if($contem) {
			$resultado = is_array($resultado)
				? array_map(function(mixed $tupla): array {
						return $tupla->json();
					}, $resultado)
				: $resultado->json();
		}

		http_response_code($contem ? 200 : 404);
		exit(json_encode([
			"resultado" => $resultado,
			"mensagem" => $contem
				? "Foi encontrado o registro solicitado."
				: "Não foi encontrado nenhum registro.",
			"erro" => ErroController::last(),
			"sucesso" => true
		]));
	}

	// Não foram informados os parâmetros corretamente
	else {
		http_response_code(400);
		exit(json_encode([
			"resultado" => null,
			"mensagem" => "A requisição é inválida.",
			"erro" => ErroController::last(),
			"sucesso" => false
		]));
	}
}


// O metódo recebido é POST
elseif($request === "POST") {
	if(!$configuracao::get("update", "crud")) {
		http_response_code(403);
		exit(json_encode([
			"resultado" => null,
			"mensagem" => "A alteração de dados está desabilitada.",
			"erro" => ErroController::last(),
			"sucesso" => false
		]));
	}
	// O usuário não está autenticado
	elseif(!Operador::logged()) {
		http_response_code(401);
		exit(json_encode([
			"resultado" => null,
			"mensagem" => "É necessário autenticar-se antes de realizar modificações.",
			"erro" => ErroController::last(),
			"sucesso" => false
		]));
	}

	$classe = ucfirst(filter_input(INPUT_POST, "classe", FILTER_UNSAFE_RAW));

	// Verifica se a classe informada está correta
	if(!empty($classe) && class_exists($classe . "DAO") && method_exists($classe . "DAO", "update")) {
		$objeto = new $classe;
		// Recebe as variáveis do objeto
		$chaves = array_map(function(ReflectionProperty $objeto): string {
			return $objeto->name;
		}, $objeto->variaveis);
		$erros = [];

		$valores = [];
		$vetor = array_filter(array_map(function(string $indice) use (&$valores): string {
			$token = strpos($indice, "->");
			if($token !== false) {
				$valores[] = substr($indice, 0, $token);
				return substr($indice, $token + 2);
			}
			return "";
		}, array_keys($_POST)));
		$valores = array_unique($valores);

		// Passa os valores do vetor POST para a classe
		array_map(function(string $chave) use ($objeto, &$erros, $valores, $vetor): void {
			if(!is_array($objeto->$chave)) {
				try {
					if(is_object($objeto->$chave)) {
						$subclasse = ucfirst($chave);
						$objeto->$chave = new $subclasse(filter_input(INPUT_POST, $chave, FILTER_UNSAFE_RAW));
					}
					else {
						$objeto->$chave = filter_input(INPUT_POST, $chave, FILTER_UNSAFE_RAW);
					}

					if(!isset($_POST[$chave])) {
						throw new ValueError("É necessário informar a chave '" . $chave . "'");
					}
				}
				catch(Throwable $th) {
					$erros[] = $chave;
				}
			}
			elseif(is_array($objeto->$chave) && in_array($chave, $valores)) {
				$resultado = [];
				$orientador = array_values($valores)[0];
				$subclasse = ucfirst(substr($orientador, 0, -1));

				for($k = 0; $k < count($_POST[$orientador . "->" . array_values($vetor)[0]]); $k++) {
					$parametros = array_map(function(string $parametro) use ($orientador, $k): mixed {
						$instanciador = ucfirst($parametro);
						$valor = $_POST[$orientador . "->" . $parametro][$k];
						return class_exists($instanciador) && defined($instanciador . "::TABELA")
						? new $instanciador($valor)
						: $valor;
					}, $vetor);
					$resultado[] = new $subclasse(...$parametros);
				}
				$objeto->$chave = $resultado;
			}
		}, $chaves);

		if(count($erros) > 0) {
			http_response_code(406);
			exit(json_encode([
				"resultado" => null,
				"mensagem" => "Não foi possível realizar a modificação, atente-se ao(s) campo(s): " . implode(", ", $erros) . ".",
				"erro" => ErroController::last(),
				"sucesso" => false
			]));
		}

		// Realiza a alteração do registro
		if(call_user_func($classe . "DAO::update", $objeto)) {
			http_response_code(200);
			exit(json_encode([
				"resultado" => $objeto->json(),
				"mensagem" => "Alteração realizada com sucesso às " . date("H:i:s") . ".",
				"erro" => ErroController::last(),
				"sucesso" => true
			]));
		}

		http_response_code(406);
		exit(json_encode([
			"resultado" => null,
			"mensagem" => "Não foi possível realizar a alteração.",
			"erro" => ErroController::last(),
			"sucesso" => false
		]));
	}
	// Não foi informado o nome da classe na requisição
	else {
		http_response_code(400);
		exit(json_encode([
			"resultado" => null,
			"mensagem" => "Atente-se aos parâmetros informados na requisição POST.",
			"erro" => ErroController::last(),
			"sucesso" => false
		]));
	}
}


// O método recebido é diferente de GET ou POST
else {
	http_response_code(405);
	exit(json_encode([
		"resultado" => null,
		"mensagem" => "O metódo necessário para o envio deve ser GET ou POST. " . $request . " não é permitido.",
		"erro" => ErroController::last(),
		"sucesso" => false
	]));
}
