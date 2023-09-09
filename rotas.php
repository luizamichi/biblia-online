<?php

require_once __DIR__ . "/autoload.php";

$requisicao = strtok($_SERVER["REQUEST_URI"] ?? "", "?");
$parametros = array_values(array_filter(explode("/", $requisicao)));
$direcionador = $parametros[0] ?? "";

// Versão padrão
$versao = "NVI";
$capitulo = 0;
$versiculo = 0;

// Carrega os arquivos estáticos antes de tentar se comunicar com o banco de dados
$arquivo = __DIR__ . $requisicao;
if(is_file($arquivo) && !in_array(substr($requisicao, 1), Configuracao::ini()::get("restrict"))) {
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
	elseif(in_array($direcionador, ["", "login", "autores", "livros", "testamentos", "versoes"])) {
		RotaController::erro();
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
	case "api": // Realiza CRUD no banco de dados
		RotaController::api();
		break;
	case "login": // Rota específica para login/logout
		RotaController::login();
		break;
	case "autores": // Exibe todos os autores
		RotaController::autores();
		break;
	case "livros": // Exibe todos os livros
		RotaController::livros($parametros[2] ?? "");
		break;
	case "testamentos": // Exibe todos os testamentos
		RotaController::testamentos();
		break;
	case "versoes": // Exibe todas as versões
		RotaController::versoes();
		break;
	default:
		if(in_array(strtoupper($direcionador), $autores)) { // Exibe um autor em específico
			RotaController::autor($direcionador);
		}
		elseif(in_array(strtoupper($direcionador), $livros)) {
			if($versiculo !== 0) { // Exibe um versículo específico
				RotaController::versiculo($versao, strtoupper($direcionador), $capitulo, $versiculo);
			}
			elseif($capitulo !== 0) { // Exibe um capítulo específico
				RotaController::capitulo(strtoupper($direcionador), $versao, $capitulo);
			}
			else { // Exibe um livro específico
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
