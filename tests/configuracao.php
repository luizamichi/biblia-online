<?php

require_once __DIR__ . "/../models/Configuracao.php";

function testeModelConfiguracao() {
	$config = Configuracao::ini();

	echo "Banco de dados" . PHP_EOL;
	echo "Driver: " . $config->get("driver", "database") . PHP_EOL;
	echo "Endereço: " . $config->get("host", "database") . PHP_EOL;
	echo "Porta: " . $config->get("port", "database") . PHP_EOL;
	echo "Esquema: " . $config->get("schema", "database") . PHP_EOL;
	echo "Usuário: " . $config->get("username", "database") . PHP_EOL;
	echo "Senha: " . $config->get("password", "database") . PHP_EOL;

	echo PHP_EOL . "Projeto" . PHP_EOL;
	echo "Endereço base: " . $config->get("base_url", "project") . PHP_EOL;
	echo "Nome do sistema: " . $config->get("system_name", "project") . PHP_EOL;
	echo "Descrição: " . $config->get("description", "project") . PHP_EOL;
	echo "Versão padrão: " . $config->get("default_version", "project") . PHP_EOL;
	echo "Nome da sessão: " . $config->get("session_name", "project") . PHP_EOL;
	echo "Usuário: " . $config->get("username", "project") . PHP_EOL;
	echo "Senha: " . $config->get("password", "project") . PHP_EOL;
	echo "Depuração: " . $config->get("debug", "project") . PHP_EOL;

	echo PHP_EOL . "CRUD" . PHP_EOL;
	echo "Leitura: " . $config->get("read", "crud") . PHP_EOL;
	echo "Escrita: " . $config->get("insert", "crud") . PHP_EOL;
	echo "Atualização: " . $config->get("update", "crud") . PHP_EOL;
	echo "Remoção: " . $config->get("delete", "crud") . PHP_EOL;

	echo PHP_EOL . "Erro" . PHP_EOL;
	echo "Mensagem: " . $config->get("message", "error") . PHP_EOL;
	echo "Tipo: " . $config->get("type", "error") . PHP_EOL;
	echo "Linha: " . $config->get("line", "error") . PHP_EOL;
	echo "Arquivo: " . $config->get("file", "error") . PHP_EOL;

	echo PHP_EOL . "Restrição" . PHP_EOL;
	echo "01: " . $config->get("1", "restrict") . PHP_EOL;
	echo "02: " . $config->get("2", "restrict") . PHP_EOL;
	echo "03: " . $config->get("3", "restrict") . PHP_EOL;
	echo "04: " . $config->get("4", "restrict") . PHP_EOL;
	echo "05: " . $config->get("5", "restrict") . PHP_EOL;
	echo "06: " . $config->get("6", "restrict") . PHP_EOL;
	echo "07: " . $config->get("7", "restrict") . PHP_EOL;
	echo "08: " . $config->get("8", "restrict") . PHP_EOL;
	echo "09: " . $config->get("9", "restrict") . PHP_EOL;
	echo "10: " . $config->get("10", "restrict") . PHP_EOL;
	echo "11: " . $config->get("11", "restrict") . PHP_EOL;
	echo "12: " . $config->get("12", "restrict") . PHP_EOL;
	echo "13: " . $config->get("13", "restrict") . PHP_EOL;
	echo "14: " . $config->get("14", "restrict") . PHP_EOL;
	echo "15: " . $config->get("15", "restrict") . PHP_EOL;
	echo "16: " . $config->get("16", "restrict") . PHP_EOL;
	echo "17: " . $config->get("17", "restrict") . PHP_EOL;
	echo "18: " . $config->get("18", "restrict") . PHP_EOL;
	echo "19: " . $config->get("19", "restrict");
}

testeModelConfiguracao();
