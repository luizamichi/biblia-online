<?php

require_once __DIR__ . "/../models/Alerta.php";

$alerta = new Alerta("Título", "Descrição");

include __DIR__ . "/../templates/alerta.php";
