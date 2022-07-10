<?php

require_once __DIR__ . "/../autoload.php";

defined("VERSAO") ?: define("VERSAO", "");

/**
 * @var ?array<Autor> $autores
 */
$autores ??= [];

usort($autores, function(Autor $autor1, Autor $autor2): int {
	return $autor1->nome <=> $autor2->nome;
});

?>

<div class="attached message ui">
	<h3 class="aligned center header icon ui">
		<i class="circular icon users"></i>
		<div id="titulo">Autores</div>
		<small><?= count($autores) === 1 ? "1 autor" : count($autores) . " autores" ?></small>
	</h3>
</div>

<div class="container grid ui">
	<div class="attached fluid segment ui">
		<div class="horizontal link list ui">
			<?php foreach($autores as $autor): ?>
			<a class="item" href="<?= VERSAO . $autor->apelido ?>"><?= $autor->nome ?></a>
			<?php endforeach; ?>
		</div>
	</div>
</div>
