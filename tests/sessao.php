<?php

require_once __DIR__ . "/../models/Sessao.php";

Sessao::set("usuario", "joao");
Sessao::set("email", "joao@exemplo.com");
Sessao::set("senha", "123456");

echo "Usuário: " . Sessao::get("usuario") . PHP_EOL;
echo "Email: " . Sessao::get("email") . PHP_EOL;
echo "Senha: " . Sessao::get("senha") . PHP_EOL;

Sessao::unset("usuario", "email", "senha");

echo PHP_EOL . "Usuário: " . Sessao::get("usuario") . PHP_EOL;
echo "Email: " . Sessao::get("email") . PHP_EOL;
echo "Senha: " . Sessao::get("senha") . PHP_EOL;

echo PHP_EOL . "Testamentos: " . json_encode(array_map(fn($testamento) => $testamento, Sessao::testamentos()), JSON_PRETTY_PRINT);

echo PHP_EOL . "Versões: " . json_encode(array_map(fn($versao) => $versao, Sessao::versoes()), JSON_PRETTY_PRINT);
