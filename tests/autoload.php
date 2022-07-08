<?php

require_once __DIR__ . "/../autoload.php";

$config = Configuracao::ini();

print_r($config->get("restrict"));

$a = "Um";
$b = 1 + $a;
