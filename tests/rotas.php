<?php

if(($argv[1] ?? null) === "controller") {
	require_once __DIR__ . "/../controllers/RotaController.php";

	RotaController::api();
}
else {
	require_once __DIR__ . "/../rotas.php";
}
