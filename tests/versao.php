<?php

if(($argv[1] ?? null) === "dao") {
	require_once __DIR__ . "/../daos/VersaoDAO.php";

	$versao = VersaoDAO::chave(1);
	echo json_encode($versao->json(), JSON_PRETTY_PRINT);
}
elseif(($argv[1] ?? null) === "model") {
	require_once __DIR__ . "/../models/Versao.php";

	$versao = new Versao();
	echo json_encode($versao->json(), JSON_PRETTY_PRINT);
}
elseif(($argv[1] ?? null) === "template") {
	require_once __DIR__ . "/../templates/versao.php";
}
elseif(($argv[1] ?? null) === "templates") {
	require_once __DIR__ . "/../templates/versoes.php";
}
