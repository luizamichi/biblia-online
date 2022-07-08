<?php

/**
 * @var ?Configuracao $configuracao
 */
$configuracao ??= Configuracao::ini();

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
	<meta charset="UTF-8"/>
	<meta http-equiv="X-UA-Compatible" content="IE=edge"/>
	<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
	<meta name="description" content="<?= $configuracao::getStr("description", "project") ?>"/>
	<meta name="author" content="Luiz Joaquim Aderaldo Amichi"/>

	<title><?= $configuracao::getStr("system_name", "project") ?></title>
	<base href="<?= $configuracao::getStr("base_url", "project") ?>"/>
	<link href="stylesheets/semantic.min.css" id="tema-claro" rel="stylesheet" type="text/css"/>
	<link href="stylesheets/tema-escuro.css" id="tema-escuro" rel="stylesheet" type="text/css"/>
	<link href="images/biblia.png" rel="icon shortcut" type="image/png"/>
</head>

<body>
