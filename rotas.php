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
}
