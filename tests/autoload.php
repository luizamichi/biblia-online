<?php

require_once __DIR__ . '/../autoload.php';

$config = Configuracao::ini();

print_r($config->get("restrict"));
