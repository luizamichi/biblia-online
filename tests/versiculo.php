<?php

if(($argv[1] ?? null) === "dao") {
	require_once __DIR__ . "/../daos/VersiculoDAO.php";

	$versiculo = VersiculoDAO::chave(1);
	echo json_encode($versiculo->json(), JSON_PRETTY_PRINT);
}
elseif(($argv[1] ?? null) === "model") {
	require_once __DIR__ . "/../models/Versiculo.php";

	$versiculo = new Versiculo();
	echo json_encode($versiculo->json(), JSON_PRETTY_PRINT);
}
elseif(($argv[1] ?? null) === "template") {
	require_once __DIR__ . "/../templates/versiculo.php";
}
