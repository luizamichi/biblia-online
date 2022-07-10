<?php

if(($argv[1] ?? null) === "model") {
	require_once __DIR__ . "/../models/Capitulo.php";

	$capitulo = new Capitulo();

	echo "Número: " . $capitulo->numero;
	echo PHP_EOL . "Versículos: " . json_encode(array_map(fn($versiculo) => $versiculo->json(), $capitulo->versiculos), JSON_PRETTY_PRINT);
}
elseif(($argv[1] ?? null) === "template") {
	require_once __DIR__ . "/../templates/capitulo.php";
}
