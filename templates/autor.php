<?php

require_once __DIR__ . "/../autoload.php";

defined("VERSAO") ?: define("VERSAO", "");

/**
 * @var ?Autor $autor
 */
$autor ??= new Autor;

/**
 * @var ?array<Livro> $livros
 */
$livros ??= [];

?>

<div class="steps two ui">
	<div class="disabled step">
		<i class="bookmark icon"></i>
		<div class="content">
			<div class="title"><?= $livros[0]->testamento->nome ?? "" ?></div>
			<div class="description"><?= $livros[0]->testamento->abreviado ?? "" ?></div>
		</div>
	</div>
	<div class="active step">
		<i class="book icon"></i>
		<div class="content">
			<div class="title">
				<?php foreach($livros as $indice => $livro): ?>
				<a href="<?= VERSAO . $livro->abreviado ?>"><?= $livro->nome . ($indice !== count($livros) - 1 ? ", " : "") ?></a>
				<?php endforeach; ?>
			</div>
			<div class="description"><?= count($livros) === 1 ? "1 livro" : count($livros) . " livros" ?></div>
		</div>
	</div>
</div>

<div class="attached message ui">
	<h3 class="aligned center header icon ui">
		<i class="circular icon user"></i>
		<div data-title="<?= $autor->nome ?>" id="titulo">Autor</div>
		<small><?= $autor->chave ?></small>
	</h3>
</div>

<div class="container grid ui">
	<?php if(Operador::logged()): ?>
	<form action="api" class="attached fluid form segment ui" id="formulario-put" method="put">
		<input id="classe" name="classe" type="hidden" value="autor"/>
		<input id="chave" name="chave" type="hidden" value="<?= $autor->chave ?>"/>
		<div class="fields two">
			<div class="field">
				<label for="nome">Nome</label>
				<input autofocus="autofocus" id="nome" maxlength="32" name="nome" placeholder="Nome" required="required" type="text" value="<?= $autor->nome ?>"/>
			</div>
			<div class="field">
				<label for="apelido">Apelido</label>
				<input id="apelido" maxlength="16" name="apelido" placeholder="Apelido" required="required" type="text" value="<?= $autor->apelido ?>"/>
			</div>
		</div>
		<div class="field">
			<label for="sobre">Sobre</label>
			<textarea id="sobre" maxlength="65536" name="sobre" placeholder="Sobre"><?= $autor->sobre ?></textarea>
		</div>

		<div class="field inline">
			<div class="checkbox ui">
				<input id="termos" type="checkbox">
				<label for="termos">Eu aceito modificar os valores do autor.</label>
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
		<p><?= $autor->nome ?></p>
		<h3>Sobre</h3>
		<p><?= nl2br($autor->sobre ?? "") ?: "Ainda não temos informações sobre o autor." ?></p>
	</div>
	<?php endif; ?>
</div>
