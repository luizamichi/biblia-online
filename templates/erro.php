<?php

require_once __DIR__ . "/../autoload.php";

/**
 * @var ?int $codigo
 */
$codigo ??= 0;

/**
 * @var ?int $linha
 */
$linha ??= 0;

/**
 * @var ?string $local
 */
$local ??= "";

/**
 * @var ?string $descricao
 */
$descricao ??= "";

?>

<div class="message negative ui">
	<div class="header" id="titulo">Erro</div>
	<p>Ocorreu um erro em nosso sistema. Tente novamente em alguns segundos!</p>
	<p><small>Se o problema persistir, entre em contato com <strong><a href="mailto:suporte@luizamichi.com.br">suporte@luizamichi.com.br</a></strong>.</small></p>

	<?php if(Configuracao::ini()::get("debug", "project")): ?>
	<small><strong>Código:</strong> <?= $codigo ?></small>
	<br/>
	<small><strong>Linha:</strong> <?= $linha ?></small>
	<br/>
	<small><strong>Arquivo:</strong> <?= $local ?></small>
	<br/>
	<small><strong>Descrição:</strong> <?= nl2br($descricao) ?></small>
	<?php endif; ?>
</div>
