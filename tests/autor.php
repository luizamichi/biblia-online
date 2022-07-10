<?php

if(($argv[1] ?? null) === "model") {
	require_once __DIR__ . "/../models/Autor.php";

	$autor = new Autor();
	echo json_encode($autor->json(), JSON_PRETTY_PRINT);
}
elseif(($argv[1] ?? null) === "template") {
	require_once __DIR__ . "/../templates/autor.php";
}
elseif(($argv[1] ?? null) === "templates") {
	require_once __DIR__ . "/../templates/autores.php";
}
