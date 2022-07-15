<?php

if(($argv[1] ?? null) === "dao") {
	require_once __DIR__ . "/../daos/LivroDAO.php";

	$livro = LivroDAO::chave(1);
	echo json_encode($livro->json(), JSON_PRETTY_PRINT);
}
elseif(($argv[1] ?? null) === "model") {
	require_once __DIR__ . "/../models/Livro.php";

	$livro = new Livro();
	echo json_encode($livro->json(), JSON_PRETTY_PRINT);
}
elseif(($argv[1] ?? null) === "template") {
	require_once __DIR__ . "/../templates/livro.php";
}
elseif(($argv[1] ?? null) === "templates") {
	require_once __DIR__ . "/../templates/livros.php";
}
