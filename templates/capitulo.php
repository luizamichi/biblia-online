<?php

require_once __DIR__ . "/../autoload.php";

defined("VERSAO") ?: define("VERSAO", "");

/**
 * @var ?Capitulo $capitulo
 */
$capitulo ??= new Capitulo(0, [new Versiculo]);

?>

<div class="steps three ui">
	<div class="disabled step">
		<i class="alternate calendar icon"></i>
		<div class="content">
			<div class="title"><?= $capitulo->versiculos[0]->versao?->nome ?></div>
			<div class="description"><?= $capitulo->versiculos[0]->versao?->abreviado ?></div>
		</div>
	</div>
	<div class="step">
		<i class="bookmark icon"></i>
		<div class="content">
			<div class="title">
				<a href="<?= VERSAO . "livros/" . $capitulo->versiculos[0]->livro?->testamento?->abreviado ?>"><?= $capitulo->versiculos[0]->livro?->testamento?->nome ?></a>
			</div>
			<div class="description"><?= $capitulo->versiculos[0]->livro?->testamento?->abreviado ?></div>
		</div>
	</div>
	<div class="active step">
		<i class="book icon"></i>
		<div class="content">
			<div class="title">
				<a href="<?= VERSAO . $capitulo->versiculos[0]->livro?->abreviado ?>"><?= $capitulo->versiculos[0]->livro?->nome ?></a>
			</div>
			<div class="description"><?= $capitulo->versiculos[0]->livro?->abreviado ?></div>
		</div>
	</div>
</div>

<div class="attached message ui">
	<h3 class="aligned center header icon ui">
		<i class="align circular icon justify"></i>
		<div data-title="<?= $capitulo->versiculos[0]->livro?->nome . " " . $capitulo->numero ?>" id="titulo">Capítulo</div>
		<small><?= $capitulo->numero ?></small>
	</h3>
</div>

<div class="container grid ui">
	<?php if(Operador::logged()): ?>
	<form action="api" class="attached fluid form segment ui" id="formulario-put" method="put">
		<input name="classe" type="hidden" value="capitulo"/>
		<input name="numero" type="hidden" value="<?= $capitulo->numero ?>"/>

		<?php foreach($capitulo->versiculos as $versiculo): ?>
		<div class="field">
			<input name="versiculos->chave[]" type="hidden" value="<?= $versiculo->chave ?>"/>
			<input name="versiculos->versao[]" type="hidden" value="<?= $versiculo->versao?->chave ?>"/>
			<input name="versiculos->livro[]" type="hidden" value="<?= $versiculo->livro?->chave ?>"/>
			<input name="versiculos->capitulo[]" type="hidden" value="<?= $versiculo->capitulo ?>"/>
			<input name="versiculos->numero[]" type="hidden" value="<?= $versiculo->numero ?>"/>

			<label for="versiculo-<?= $versiculo->numero ?>">
				Versículo <?= $versiculo->numero ?>
				<a href="<?= $versiculo->versao?->abreviado . "/" . $versiculo->livro?->abreviado . "/" . $capitulo->numero . "/" . $versiculo->numero ?>"><i class="icon linkify"></i></a>
			</label>
			<textarea <?= $versiculo->numero === 1 ? "autofocus=\"autofocus\"" : "" ?> id="versiculo-<?= $versiculo->numero ?>" maxlength="65536" name="versiculos->texto[]" placeholder="Versículo <?= $versiculo->numero ?>" required="required"><?= $versiculo->texto ?></textarea>
		</div>
		<?php endforeach; ?>

		<div class="field inline">
			<div class="checkbox ui">
				<input id="termos" type="checkbox">
				<label for="termos">Eu aceito modificar os valores do capítulo.</label>
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
		<p class="container justified ui">
			<?php foreach($capitulo->versiculos as $versiculo): ?>
			<small class="versiculo"><?= $versiculo->texto ? $versiculo->numero : "" ?></small> <?= nl2br($versiculo->texto) ?>
			<?php endforeach; ?>
		</p>
	</div>
	<?php endif; ?>
</div>
