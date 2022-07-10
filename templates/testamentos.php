<?php

require_once __DIR__ . "/../autoload.php";

defined("VERSAO") ?: define("VERSAO", "");

/**
 * @var ?array<Testamento> $testamentos
 */
$testamentos ??= [];

?>

<div class="attached message ui">
	<h3 class="aligned center header icon ui">
		<i class="bookmark circular icon"></i>
		<div id="titulo">Testamentos</div>
		<small><?= count($testamentos) === 1 ? "1 testamento" : count($testamentos) . " testamentos" ?></small>
	</h3>
</div>

<div class="container grid ui">
	<div class="attached fluid segment ui">
		<div class="horizontal link list ui">
			<?php foreach($testamentos as $testamento): ?>
			<a class="item" href="<?= VERSAO . "livros/" . $testamento->abreviado ?>"><?= $testamento->nome ?></a>
			<?php endforeach; ?>
		</div>
	</div>
</div>
