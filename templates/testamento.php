<?php

require_once __DIR__ . "/../autoload.php";

defined("VERSAO") ?: define("VERSAO", "");

/**
 * @var ?Testamento $testamento
 */
$testamento ??= new Testamento;

/**
 * @var ?array<Livro> $livros
 */
$livros ??= [];

?>

<div class="attached message ui">
	<h3 class="aligned center header icon ui">
		<i class="bookmark circular icon"></i>
		<div data-title="<?= $testamento->nome ?>" id="titulo">Testamento</div>
		<small><?= $testamento->chave ?></small>
	</h3>
</div>

<div class="container grid ui">
	<?php if(Operador::logged()): ?>
	<form action="api" class="attached fluid form segment ui" id="formulario-put" method="put">
		<input id="classe" name="classe" type="hidden" value="testamento"/>
		<input id="chave" name="chave" type="hidden" value="<?= $testamento->chave ?>"/>

		<div class="fields two">
			<div class="field">
				<label for="nome">Nome Completo</label>
				<input autofocus="autofocus" id="nome" maxlength="32" name="nome" placeholder="Nome Completo" required="required" type="text" value="<?= $testamento->nome ?>"/>
			</div>
			<div class="field">
				<label for="abreviado">Nome Abreviado</label>
				<input id="abreviado" maxlength="2" minlength="2" name="abreviado" placeholder="Nome Abreviado" required="required" type="text" value="<?= $testamento->abreviado ?>"/>
			</div>
		</div>

		<div class="field">
			<div class="horizontal link list ui">
				<?php foreach($livros as $livro): ?>
				<a class="item" href="<?= VERSAO . $livro->abreviado ?>"><?= $livro->nome ?></a>
				<?php endforeach; ?>
			</div>
		</div>

		<div class="field inline">
			<div class="checkbox ui">
				<input id="termos" type="checkbox">
				<label for="termos">Eu aceito modificar os valores do testamento.</label>
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
		<h3>Nome</h3>
		<p><?= $testamento->nome ?></p>
		<h3>Abreviado</h3>
		<p><?= $testamento->abreviado ?></p>
		<h3>Livros</h3>
		<div class="horizontal link list ui">
			<?php foreach($livros as $livro): ?>
			<a class="item" href="<?= VERSAO . $livro->abreviado ?>"><?= $livro->nome ?></a>
			<?php endforeach; ?>
		</div>
	</div>
	<?php endif; ?>
</div>
