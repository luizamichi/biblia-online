<?php

if(($argv[1] ?? null) === "dao") {
	require_once __DIR__ . "/../daos/CapituloDAO.php";

	$capitulo = CapituloDAO::numeroLivroVersao(1, "LC", "ARA1993");

	echo "Número: " . $capitulo->numero;
	echo PHP_EOL . "Versículos: " . json_encode(array_map(fn($versiculo) => $versiculo->json(), $capitulo->versiculos), JSON_PRETTY_PRINT);
}
elseif(($argv[1] ?? null) === "model") {
	require_once __DIR__ . "/../models/Capitulo.php";

	$capitulo = new Capitulo();

	echo "Número: " . $capitulo->numero;
	echo PHP_EOL . "Versículos: " . json_encode(array_map(fn($versiculo) => $versiculo->json(), $capitulo->versiculos), JSON_PRETTY_PRINT);
}
elseif(($argv[1] ?? null) === "template") {
	require_once __DIR__ . "/../templates/capitulo.php";
}
