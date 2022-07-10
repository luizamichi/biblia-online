<?php

require_once __DIR__ . "/../models/Biblia.php";

$biblia = new Biblia();

echo "Versão: " . json_encode($biblia->versao->json(), JSON_PRETTY_PRINT);
echo PHP_EOL . "Livros: " . json_encode(array_map(fn($livro) => $livro->json(), $biblia->livros), JSON_PRETTY_PRINT);
