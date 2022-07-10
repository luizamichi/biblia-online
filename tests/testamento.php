<?php

if(($argv[1] ?? null) === "model") {
	require_once __DIR__ . "/../models/Testamento.php";

	$testamento = new Testamento();
	echo json_encode($testamento->json(), JSON_PRETTY_PRINT);
}
elseif(($argv[1] ?? null) === "template") {
	require_once __DIR__ . "/../templates/testamento.php";
}
elseif(($argv[1] ?? null) === "templates") {
	require_once __DIR__ . "/../templates/testamentos.php";
}
