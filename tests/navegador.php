<?php

require_once __DIR__ . "/../models/Navegador.php";

$navegador = new Navegador(1, "https://www.google.com", "https://www.bing.com");

include __DIR__ . "/../templates/navegador.php";
