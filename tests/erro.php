<?php

require_once __DIR__ . "/../autoload.php";

if(($argv[1] ?? null) === "controller") {
	echo "Erro atual" . PHP_EOL;
	print_r(ErroController::current(new Exception("Exceção", 123)));

	echo PHP_EOL . "Último erro" . PHP_EOL;
	print_r(ErroController::last());
}
elseif(($argv[1] ?? null) === "template") {
	require_once __DIR__ . "/../templates/erro.php";
}
