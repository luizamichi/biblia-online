<?php

// Cadastra o autoload de todas as classes do sistema
spl_autoload_register(function(string $classe): void {
	$diretorios = ["controllers", "daos", "models"];

	foreach($diretorios as $diretorio) {
		$arquivo = __DIR__ . DIRECTORY_SEPARATOR . $diretorio . DIRECTORY_SEPARATOR . $classe . ".php";

		if(file_exists($arquivo)) {
			include_once $arquivo;
			break;
		}
	}
});


// Ativa a sessão do PHP
if(session_status() !== PHP_SESSION_ACTIVE) {
	session_name(Configuracao::ini()::getStr("session_name", "project"));
	session_start();
	session_regenerate_id();
}


// Ativa a depuração de erros
if(Configuracao::ini()::get("debug", "project")) {
	ini_set("display_errors", 1);
	ini_set("display_startup_errors", 1);
	error_reporting(E_ALL);
}
else {
	ini_set("display_errors", 0);
	ini_set("display_startup_errors", 0);
	error_reporting(~E_ALL);
}
