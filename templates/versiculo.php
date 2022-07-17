<?php

require_once __DIR__ . "/../autoload.php";

defined("VERSAO") ?: define("VERSAO", "");

/**
 * @var ?Versiculo $versiculo
 */
$versiculo ??= new Versiculo;

?>

<div class="four steps ui">
	<div class="disabled step">
		<i class="alternate calendar icon"></i>
		<div class="content">
			<div class="title"><?= $versiculo->versao?->nome ?></div>
			<div class="description"><?= $versiculo->versao?->abreviado ?></div>
		</div>
	</div>
	<div class="step">
		<i class="bookmark icon"></i>
		<div class="content">
			<div class="title">
				<a href="<?= VERSAO . "livros/" . $versiculo->livro?->testamento?->abreviado ?>"><?= $versiculo->livro?->testamento?->nome ?></a>
			</div>
			<div class="description"><?= $versiculo->livro?->testamento?->abreviado ?></div>
		</div>
	</div>
	<div class="step">
		<i class="book icon"></i>
		<div class="content">
			<div class="title">
				<a href="<?= $versiculo->versao?->abreviado . "/" . $versiculo->livro?->abreviado ?>"><?= $versiculo->livro?->nome ?></a>
			</div>
			<div class="description"><?= $versiculo->livro?->abreviado ?></div>
		</div>
	</div>
	<div class="active step">
		<i class="align icon justify"></i>
		<div class="content">
			<div class="title">
				<a href="<?= $versiculo->versao?->abreviado . "/" . $versiculo->livro?->abreviado . "/" . $versiculo->capitulo ?>">Capítulo</a>
			</div>
			<div class="description"><?= $versiculo->capitulo ?></div>
		</div>
	</div>
</div>

<div class="attached message ui">
	<h3 class="aligned center header icon ui">
		<i class="circular cursor i icon"></i>
		<div data-title="<?= $versiculo->livro?->nome . " " . $versiculo->capitulo . ", " . $versiculo->numero ?> " id="titulo">Versículo</div>
		<small><?= $versiculo->numero ?></small>
	</h3>
</div>

<div class="container grid ui">
	<?php if(Operador::logged()): ?>
	<form action="api" class="attached fluid form segment ui" id="formulario-put" method="put">
		<input id="classe" name="classe" type="hidden" value="versiculo"/>
		<input id="chave" name="chave" type="hidden" value="<?= $versiculo->chave ?>"/>
		<input id="capitulo" name="capitulo" type="hidden" value="<?= $versiculo->capitulo ?>"/>
		<input id="versao" name="versao" type="hidden" value="<?= $versiculo->versao?->chave ?>"/>
		<input id="livro" name="livro" type="hidden" value="<?= $versiculo->livro?->chave ?>"/>

		<div class="field">
			<label for="numero">Número</label>
			<input autofocus="autofocus" id="numero" max="176" min="1" name="numero" placeholder="Número" required="required" type="number" value="<?= $versiculo->numero ?>"/>
		</div>
		<div class="field">
			<label for="texto">Texto</label>
			<textarea id="texto" maxlength="65536" name="texto" placeholder="Texto" required="required"><?= $versiculo->texto ?></textarea>
		</div>

		<div class="field inline">
			<div class="checkbox ui">
				<input id="termos" type="checkbox">
				<label for="termos">Eu aceito modificar os valores do versículo.</label>
			</div>
		</div>

		<div class="buttons ui">
			<button class="blue button ui" id="salvar" type="submit">
				<i class="icon save"></i>
				Salvar
			</button>
			<div class="or" data-text="ou"></div>
			<button class="button ui" id="cancelar" type="button">
				<i class="ban icon"></i>
				Cancelar
			</button>
		</div>
	</form>

	<?php else: ?>
	<div class="attached fluid segment ui">
		<p class="container justified ui"><?= $versiculo->texto ?></p>
	</div>
	<?php endif; ?>
</div>
