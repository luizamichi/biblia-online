<?php

$configuracao ??= Configuracao::ini();

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
	<meta charset="UTF-8"/>
	<meta http-equiv="X-UA-Compatible" content="IE=edge"/>
	<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
	<meta name="description" content="<?= $configuracao::get("description", "project") ?>"/>

	<title><?= $configuracao::get("system_name", "project") ?></title>
	<base href="<?= $configuracao::get("base_url", "project") ?>"/>
	<link href="stylesheets/semantic.min.css" id="tema-claro" rel="stylesheet" type="text/css"/>
	<link href="stylesheets/tema-escuro.css" id="tema-escuro" rel="stylesheet" type="text/css"/>
	<link href="images/biblia.png" rel="icon shortcut" type="image/png"/>
</head>

<body>
