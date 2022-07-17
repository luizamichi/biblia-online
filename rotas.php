<?php

require_once __DIR__ . "/autoload.php";

$requisicao = is_string($_SERVER["REQUEST_URI"] ?? null) ? $_SERVER["REQUEST_URI"] : "";
$requisicao = (string) strtok($requisicao, "?");
$parametros = array_values(array_filter(explode("/", $requisicao)));
$baseDir = basename(__DIR__);

if(!empty($parametros) && $parametros[0] === $baseDir) {
	array_shift($parametros);
	$requisicao = (string) preg_replace("#^/{$baseDir}#", "", $requisicao);
}

$direcionador = $parametros[0] ?? "";
define("DIRECIONADOR", $direcionador);

// Versão padrão
$versao = Configuracao::ini()::getStr("default_version", "project");
$capitulo = 0;
$versiculo = 0;

// Carrega os arquivos estáticos antes de tentar se comunicar com o banco de dados
$arquivo = __DIR__ . $requisicao;
if(is_file($arquivo) && !in_array(substr($requisicao, 1), (array) Configuracao::ini()::get("restrict"))) {
	RotaController::files($arquivo);
	exit;
}

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
		RotaController::erro($th);
		exit;
	}
}

// Carrega os valores da sessão (para evitar consulta ao banco de dados)
$autores = Sessao::autores();
$livros = Sessao::livros();
$versoes = Sessao::versoes();

// Foi informada a versão desejada
if(in_array(strtoupper($parametros[0] ?? ""), $versoes)) {
	$versao = strtoupper($parametros[0]);
	$direcionador = $parametros[1] ?? "";
	$capitulo = (int) ($parametros[2] ?? 0);
	$versiculo = (int) ($parametros[3] ?? 0);
}

define("VERSAO", $versao . "/");

switch($direcionador) {
	// Realiza CRUD no banco de dados
	case "api":
		RotaController::api();
		break;
	// Rota específica para login/logout
	case "login":
		RotaController::login();
		break;
	// Exibe todos os autores
	case "autores":
		RotaController::autores();
		break;
	// Exibe todos os livros
	case "livros":
		RotaController::livros($parametros[2] ?? "");
		break;
	// Exibe todos os testamentos
	case "testamentos":
		RotaController::testamentos();
		break;
	// Exibe todas as versões
	case "versoes":
		RotaController::versoes();
		break;
	default:
		// Exibe um autor em específico
		if(in_array(strtoupper($direcionador), $autores)) {
			RotaController::autor($direcionador);
		}
		elseif(in_array(strtoupper($direcionador), $livros)) {
			// Exibe um versículo específico
			if($versiculo !== 0) {
				RotaController::versiculo($versao, strtoupper($direcionador), $capitulo, $versiculo);
			}
			// Exibe um capítulo específico
			elseif($capitulo !== 0) {
				RotaController::capitulo(strtoupper($direcionador), $versao, $capitulo);
			}
			// Exibe um livro específico
			else {
				RotaController::livro(strtoupper($direcionador));
			}
		}
		else {
			if(Operador::logged()) {
				RotaController::versao($versao);
			}
			else {
				RotaController::home();
			}
		}
		break;
}
