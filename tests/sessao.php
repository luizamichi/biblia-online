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
