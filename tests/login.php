<?php

if(($argv[1] ?? null) === "template") {
	require_once __DIR__ . "/../templates/login.html";
}
else {
	$_POST["username"] = "Usuário";
	$_POST["password"] = "Senha";
	$_POST["logout"] = 0;

	require_once __DIR__ . "/../login.php";
}
