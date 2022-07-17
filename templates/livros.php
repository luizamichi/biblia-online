<?php

require_once __DIR__ . "/../autoload.php";

defined("VERSAO") ?: define("VERSAO", "");

/**
 * @var ?array<Livro> $livros
 */
$livros ??= [];

usort($livros, function(Livro $livro1, Livro $livro2): int {
	$testamento = $livro1->testamento?->abreviado <=> $livro2->testamento?->abreviado;
	$posicao = $livro1->posicao <=> $livro2->posicao;
	return $testamento ?: $posicao;
});

?>

<div class="attached message ui">
	<h3 class="aligned center header icon ui">
		<i class="book circular icon"></i>
		<div id="titulo">Livros</div>
		<small><?= count($livros) === 1 ? "1 livro" : count($livros) . " livros" ?></small>
	</h3>
</div>

<div class="container grid ui">
	<div class="attached fluid segment ui">
		<div class="horizontal link list ui">
			<?php foreach($livros as $livro): ?>
			<a class="item" href="<?= VERSAO . $livro->abreviado ?>"><?= $livro->nome ?></a>
			<?php endforeach; ?>
		</div>
	</div>
</div>
