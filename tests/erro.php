<?php

require_once __DIR__ . "/../controllers/ErroController.php";

echo "Erro atual" . PHP_EOL;
print_r(ErroController::current(new Exception("Exceção", 123)));

echo PHP_EOL . "Último erro" . PHP_EOL;
print_r(ErroController::last());
