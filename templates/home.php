<?php

require_once __DIR__ . "/../autoload.php";

/**
 * @var ?string $titulo
 */
$titulo ??= "Bíblia Online";

/**
 * @var ?Versiculo $versiculoAleatorio
 */
$versiculoAleatorio ??= new Versiculo;

/**
 * @var ?Versiculo $versiculoDiario
 */
$versiculoDiario ??= new Versiculo;

/**
 * @var ?Versiculo $versiculoSemanal
 */
$versiculoSemanal ??= new Versiculo;

/**
 * @var ?Versiculo $versiculoMensal
 */
$versiculoMensal ??= new Versiculo;

?>

<section class="container ui">
	<div class="segment ui">
		<h1 class="aligned center header ui">
			<div id="titulo"><?= $titulo ?></div>
		</h1>
	</div>

	<h2 class="header ui">
		<i class="icon left quote"></i>
		<span class="content">
			Versículo Aleatório
		</span>
	</h2>
	<p><?= $versiculoAleatorio->texto ?></p>
	<small>
		<a href="<?= $versiculoAleatorio->versao?->abreviado . "/" . ($versiculoAleatorio->livro?->abreviado ?: "ALEATORIO") . "/" . $versiculoAleatorio->capitulo . "/" . $versiculoAleatorio->numero ?>">
			<?= $versiculoAleatorio->livro?->nome . " " . $versiculoAleatorio->capitulo . ":" . $versiculoAleatorio->numero ?>
		</a>
	</small>

	<h2 class="header ui">
		<i class="icon quote right"></i>
		<span class="content">
			Versículo Diário
		</span>
	</h2>
	<p><?= $versiculoDiario->texto ?></p>
	<small>
		<a href="<?= $versiculoDiario->versao?->abreviado . "/" . ($versiculoDiario->livro?->abreviado ?: "DIARIO") . "/" . $versiculoDiario->capitulo . "/" . $versiculoDiario->numero ?>">
			<?= $versiculoDiario->livro?->nome . " " . $versiculoDiario->capitulo . ":" . $versiculoDiario->numero ?>
		</a>
	</small>

	<h2 class="header ui">
		<i class="icon left quote"></i>
		<span class="content">
			Versículo Semanal
		</span>
	</h2>
	<p><?= $versiculoSemanal->texto ?></p>
	<small>
		<a href="<?= $versiculoSemanal->versao?->abreviado . "/" . ($versiculoSemanal->livro?->abreviado ?: "SEMANAL") . "/" . $versiculoSemanal->capitulo . "/" . $versiculoSemanal->numero ?>">
			<?= $versiculoSemanal->livro?->nome . " " . $versiculoSemanal->capitulo . ":" . $versiculoSemanal->numero ?>
		</a>
	</small>

	<h2 class="header ui">
		<i class="icon quote right"></i>
		<span class="content">
			Versículo Mensal
		</span>
	</h2>
	<p><?= $versiculoMensal->texto ?></p>
	<small>
		<a href="<?= $versiculoMensal->versao?->abreviado . "/" . ($versiculoMensal->livro?->abreviado ?: "MENSAL") . "/" . $versiculoMensal->capitulo . "/" . $versiculoMensal->numero ?>">
			<?= $versiculoMensal->livro?->nome . " " . $versiculoMensal->capitulo . ":" . $versiculoMensal->numero ?>
		</a>
	</small>
</section>
