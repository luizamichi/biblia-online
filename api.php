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

	$classe = ucfirst((string) filter_input(INPUT_GET, "classe", FILTER_DEFAULT, FILTER_UNSAFE_RAW));
	$campo = (string) filter_input(INPUT_GET, "campo", FILTER_DEFAULT, FILTER_UNSAFE_RAW);
	$consulta = filter_input(INPUT_GET, "consulta", FILTER_DEFAULT, FILTER_UNSAFE_RAW);
	$argumentos = filter_input(INPUT_GET, "consulta", FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);

	// Faz um match da consulta -> parâmetro de consulta, campo -> função da classe DAO
	if(method_exists($classe . "DAO", $campo)) {
		try {
			/**
			 * @var array<Modelo>|Modelo|null $resultado
			 */
			$resultado = null;

			$callback = $classe . "DAO::" . $campo;
			if(is_callable($callback)) {
				/**
				 * @var array<Modelo>|Modelo|null $resultado
				 */
				$resultado = is_array($argumentos)
				? call_user_func_array($callback, $argumentos)
				: call_user_func($callback, $consulta);
			}
			else {
				exit(json_encode([
					"resultado" => null,
					"mensagem" => "A requisição está incorreta.",
					"erro" => ErroController::last(),
					"sucesso" => false
				]));
			}
		}
		catch(Throwable $th) {
			exit(json_encode([
				"resultado" => null,
				"mensagem" => "A requisição está parcialmente correta.",
				"erro" => ErroController::current($th),
				"sucesso" => false
			]));
		}

		$contem = (is_object($resultado) ? ($resultado->chave ?? $resultado->numero ?? 0) : (is_array($resultado) ? count($resultado) : 0)) > 0;
		if($contem) {
			if(is_array($resultado)) {
				$resultado = array_map(function(mixed $tupla): array {
					return $tupla->json();
				}, $resultado);

				$quantidade = count($resultado);
				if($quantidade === 1) {
					$mensagem = "Foi encontrado " . $quantidade . " registro solicitado.";
				}
				else {
					$mensagem = "Foram encontrados os " . $quantidade . " registros solicitados.";
				}
			}
			else {
				$resultado = $resultado?->json();
				$mensagem = "Foi encontrado o registro solicitado.";
			}
		}

		http_response_code($contem ? 200 : 404);
		exit(json_encode([
			"resultado" => $resultado,
			"mensagem" => $contem ? $mensagem : "Não foi encontrado nenhum registro.",
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

	$classe = ucfirst((string) filter_input(INPUT_POST, "classe", FILTER_UNSAFE_RAW));

	// Verifica se a classe informada está correta
	if(!empty($classe) && class_exists($classe . "DAO") && method_exists($classe . "DAO", "insert")) {
		/**
		 * @var Modelo $objeto
		 */
		$objeto = new $classe;

		// Recebe as variáveis do objeto
		$chaves = array_map(function(ReflectionProperty $objeto): string {
			return $objeto->name;
		}, $objeto->variaveis());
		$erros = [];

		$valores = [];
		$vetor = array_filter(array_map(function(int|string $indice) use(&$valores): string {
			$token = strpos((string) $indice, "->");
			if($token !== false) {
				$valores[] = substr((string) $indice, 0, $token);
				return substr((string) $indice, $token + 2);
			}
			return "";
		}, array_keys($_POST)));
		$valores = array_unique($valores);

		// Passa os valores do vetor POST para a classe
		array_map(function(string $chave) use($objeto, &$erros, $valores, $vetor): void {
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
						throw new ValueError("É necessário informar a chave '" . $chave . "'.");
					}
				}
				catch(Throwable $_) {
					$erros[] = $chave;
				}
			}
			elseif(is_array($objeto->$chave) && in_array($chave, $valores)) {
				$resultado = [];
				$orientador = array_values($valores)[0];
				$subclasse = ucfirst(substr($orientador, 0, -1));

				for($k = 0; $k < count((array) $_POST[$orientador . "->" . array_values($vetor)[0]]); $k++) {
					$parametros = array_map(function(string $parametro) use($orientador, $k): mixed {
						$instanciador = ucfirst($parametro);
						$valor = $_POST[$orientador . "->" . $parametro] ?? [];
						$valor = ((array) $valor)[$k] ?? null;
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
				"mensagem" => "Não foi possível realizar a inserção, atente-se ao(s) campo(s): " . implode(", ", $erros) . ".",
				"erro" => ErroController::last(),
				"sucesso" => false
			]));
		}

		try {
			$callback = $classe . "DAO::insert";

			// Realiza a inserção do registro
			if(is_callable($callback) && call_user_func_array($callback, [&$objeto])) {
				http_response_code(200);
				exit(json_encode([
					"resultado" => $objeto->json(),
					"mensagem" => "Inserção realizada com sucesso " . date("d/m/Y") . " às " . date("H:i:s") . ".",
					"erro" => ErroController::last(),
					"sucesso" => true
				]));
			}

			http_response_code(406);
			exit(json_encode([
				"resultado" => null,
				"mensagem" => "Não foi possível realizar a inserção.",
				"erro" => ErroController::last(),
				"sucesso" => false
			]));
		}
		catch(Throwable $th) {
			exit(json_encode([
				"resultado" => null,
				"mensagem" => "Houve um erro ao inserir o registro.",
				"erro" => ErroController::current($th),
				"sucesso" => false
			]));
		}
	}

	// Não foi informado o nome da classe na requisição, ou o métedo não existe
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

	$inputData = (string) file_get_contents("php://input");
	$parsedData = [];
	parse_str($inputData, $parsedData);

	$classe = $parsedData["classe"] ?? "";
	$classe = ucfirst(is_string($classe) ? $classe : "");

	// Verifica se a classe informada está correta
	if(!empty($classe) && class_exists($classe . "DAO") && method_exists($classe . "DAO", "update")) {
		/**
		 * @var Modelo $objeto
		 */
		$objeto = new $classe;

		// Recebe as variáveis do objeto
		$chaves = array_map(function(ReflectionProperty $objeto): string {
			return $objeto->name;
		}, $objeto->variaveis());
		$erros = [];

		$valores = [];
		$vetor = array_filter(array_map(function(int|string $indice) use(&$valores): string {
			$token = strpos((string) $indice, "->");
			if($token !== false) {
				$valores[] = substr((string) $indice, 0, $token);
				return substr((string) $indice, $token + 2);
			}
			return "";
		}, array_keys($parsedData)));
		$valores = array_unique($valores);

		// Passa os valores do vetor PUT para a classe
		array_map(function(string $chave) use($objeto, &$erros, $valores, $vetor, $parsedData): void {
			if(!is_array($objeto->$chave)) {
				try {
					if(is_object($objeto->$chave)) {
						$subclasse = ucfirst($chave);
						$objeto->$chave = new $subclasse(filter_var($parsedData[$chave] ?? null, FILTER_UNSAFE_RAW));
					}
					else {
						$objeto->$chave = filter_var($parsedData[$chave] ?? null, FILTER_UNSAFE_RAW);
					}

					if(!isset($parsedData[$chave])) {
						throw new ValueError("É necessário informar a chave '" . $chave . "'.");
					}
				}
				catch(Throwable $_) {
					$erros[] = $chave;
				}
			}
			elseif(is_array($objeto->$chave) && in_array($chave, $valores)) {
				$resultado = [];
				$orientador = array_values($valores)[0];
				$subclasse = ucfirst(substr($orientador, 0, -1));

				for($k = 0; $k < count((array) $parsedData[$orientador . "->" . array_values($vetor)[0]]); $k++) {
					$parametros = array_map(function(string $parametro) use($orientador, $k, $parsedData): mixed {
						$instanciador = ucfirst($parametro);
						$valor = $parsedData[$orientador . "->" . $parametro][$k];
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
				"mensagem" => "Não foi possível realizar a alteração, atente-se ao(s) campo(s): " . implode(", ", $erros) . ".",
				"erro" => ErroController::last(),
				"sucesso" => false
			]));
		}

		try {
			$callback = $classe . "DAO::update";

			// Realiza a alteração do registro
			if(is_callable($callback) && call_user_func($callback, $objeto)) {
				http_response_code(200);
				exit(json_encode([
					"resultado" => $objeto->json(),
					"mensagem" => "Alteração realizada com sucesso " . date("d/m/Y") . " às " . date("H:i:s") . ".",
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
		catch(Throwable $th) {
			exit(json_encode([
				"resultado" => null,
				"mensagem" => "Houve um erro ao alterar o registro.",
				"erro" => ErroController::current($th),
				"sucesso" => false
			]));
		}
	}

	// Não foi informado o nome da classe na requisição, ou o métedo não existe
	else {
		http_response_code(400);
		exit(json_encode([
			"resultado" => null,
			"mensagem" => "Atente-se aos parâmetros informados na requisição PUT.",
			"erro" => ErroController::last(),
			"sucesso" => false
		]));
	}
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

	$inputData = (string) file_get_contents("php://input");
	$parsedData = [];
	parse_str($inputData, $parsedData);

	$classe = $parsedData["classe"] ?? "";
	$classe = ucfirst(is_string($classe) ? $classe : "");

	// Verifica se a classe informada está correta
	if(!empty($classe) && class_exists($classe . "DAO") && method_exists($classe . "DAO", "delete")) {
		/**
		 * @var Modelo $objeto
		 */
		$objeto = new $classe;

		// Recebe as variáveis do objeto
		$chaves = array_map(function(ReflectionProperty $objeto): string {
			return $objeto->name;
		}, $objeto->variaveis());
		$erros = [];

		$valores = [];
		$vetor = array_filter(array_map(function(int|string $indice) use(&$valores): string {
			$token = strpos((string) $indice, "->");
			if($token !== false) {
				$valores[] = substr((string) $indice, 0, $token);
				return substr((string) $indice, $token + 2);
			}
			return "";
		}, array_keys($parsedData)));
		$valores = array_unique($valores);

		// Passa os valores do vetor DELETE para a classe
		array_map(function(string $chave) use($objeto, &$erros, $valores, $vetor, $parsedData): void {
			if(!is_array($objeto->$chave)) {
				try {
					if(is_object($objeto->$chave)) {
						$subclasse = ucfirst($chave);
						$objeto->$chave = new $subclasse(filter_var($parsedData[$chave] ?? null, FILTER_UNSAFE_RAW));
					}
					else {
						$objeto->$chave = filter_var($parsedData[$chave] ?? null, FILTER_UNSAFE_RAW);
					}

					if(!isset($parsedData[$chave])) {
						throw new ValueError("É necessário informar a chave '" . $chave . "'.");
					}
				}
				catch(Throwable $_) {
					$erros[] = $chave;
				}
			}
			elseif(is_array($objeto->$chave) && in_array($chave, $valores)) {
				$resultado = [];
				$orientador = array_values($valores)[0];
				$subclasse = ucfirst(substr($orientador, 0, -1));

				for($k = 0; $k < count((array) $parsedData[$orientador . "->" . array_values($vetor)[0]]); $k++) {
					$parametros = array_map(function(string $parametro) use($orientador, $k, $parsedData): mixed {
						$instanciador = ucfirst($parametro);
						$valor = $parsedData[$orientador . "->" . $parametro][$k];
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
				"mensagem" => "Não foi possível realizar a remoção, atente-se ao(s) campo(s): " . implode(", ", $erros) . ".",
				"erro" => ErroController::last(),
				"sucesso" => false
			]));
		}

		try {
			$callback = $classe . "DAO::delete";

			// Realiza a remoção do registro
			if(is_callable($callback) && call_user_func($callback, $objeto)) {
				http_response_code(200);
				exit(json_encode([
					"resultado" => $objeto->json(),
					"mensagem" => "Remoção realizada com sucesso " . date("d/m/Y") . " às " . date("H:i:s") . ".",
					"erro" => ErroController::last(),
					"sucesso" => true
				]));
			}

			http_response_code(406);
			exit(json_encode([
				"resultado" => null,
				"mensagem" => "Não foi possível realizar a remoção.",
				"erro" => ErroController::last(),
				"sucesso" => false
			]));
		}
		catch(Throwable $th) {
			exit(json_encode([
				"resultado" => null,
				"mensagem" => "Houve um erro ao remover o registro.",
				"erro" => ErroController::current($th),
				"sucesso" => false
			]));
		}
	}

	// Não foi informado o nome da classe na requisição, ou o métedo não existe
	else {
		http_response_code(400);
		exit(json_encode([
			"resultado" => null,
			"mensagem" => "Atente-se aos parâmetros informados na requisição DELETE.",
			"erro" => ErroController::last(),
			"sucesso" => false
		]));
	}
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
