<?php

require_once __DIR__ . "/../autoload.php";

defined("VERSAO") ?: define("VERSAO", "");

/**
 * @var ?Livro $livro
 */
$livro ??= new Livro;

/**
 * @var ?array<Autor> $autores
 */
$autores ??= [];

?>

<div class="steps two ui">
	<div class="step">
		<i class="bookmark icon"></i>
		<div class="content">
			<div class="title">
				<a href="<?= VERSAO . "livros/" . $livro->testamento?->abreviado ?>"><?= $livro->testamento?->nome ?></a>
			</div>
			<div class="description"><?= $livro->testamento?->abreviado ?></div>
		</div>
	</div>
	<div class="active step">
		<i class="icon <?= count($autores) === 1 ? "user" : "users" ?>"></i>
		<div class="content">
			<div class="title">
				<?php foreach($autores as $indice => $autor): ?>
				<a href="<?= VERSAO . $autor->apelido ?>"><?= $autor->nome . ($indice !== count($autores) - 1 ? ", " : "") ?></a>
				<?php endforeach; ?>
			</div>
			<div class="description"><?= count($autores) === 1 ? "1 autor" : count($autores) . " autores" ?></div>
		</div>
	</div>
</div>

<div class="attached message ui">
	<h3 class="aligned center header icon ui">
		<i class="book circular icon"></i>
		<div data-title="<?= $livro->nome ?>" id="titulo">Livro</div>
		<small><?= $livro->chave ?></small>
	</h3>
</div>

<div class="container grid ui">
	<?php if(Operador::logged()): ?>
	<form action="api" class="attached fluid form segment ui" id="formulario-put" method="put">
		<input id="classe" name="classe" type="hidden" value="livro"/>
		<input id="chave" name="chave" type="hidden" value="<?= $livro->chave ?>"/>
		<input id="testamento" name="testamento" type="hidden" value="<?= $livro->testamento?->chave ?>"/>

		<div class="fields two">
			<div class="field">
				<label for="nome">Nome Completo</label>
				<input autofocus="autofocus" id="nome" maxlength="32" name="nome" placeholder="Nome Completo" required="required" type="text" value="<?= $livro->nome ?>"/>
			</div>
			<div class="field">
				<label for="abreviado">Nome Abreviado</label>
				<input id="abreviado" maxlength="4" name="abreviado" placeholder="Nome Abreviado" required="required" type="text" value="<?= $livro->abreviado ?>"/>
			</div>
		</div>
		<div class="fields two">
			<div class="field">
				<label for="posicao">Posição</label>
				<input id="posicao" max="40" min="1" name="posicao" placeholder="Posição" required="required" type="number" value="<?= $livro->posicao ?>"/>
			</div>
			<div class="field">
				<label for="capitulos">Capítulos</label>
				<input id="capitulos" max="150" min="1" name="capitulos" placeholder="Capítulos" required="required" type="number" value="<?= $livro->capitulos ?>"/>
			</div>
		</div>
		<div class="field">
			<label for="sobre">Sobre</label>
			<textarea id="sobre" maxlength="65536" name="sobre" placeholder="Sobre"><?= $livro->sobre ?></textarea>
		</div>

		<div class="field inline">
			<div class="checkbox ui">
				<input id="termos" type="checkbox">
				<label for="termos">Eu aceito modificar os valores do livro.</label>
			</div>
		</div>

		<div class="field">
			<div class="horizontal link list ui">
				<?php foreach(range(1, $livro->capitulos) as $capitulo): ?>
				<a class="item" href="<?= VERSAO . $livro->abreviado . "/" . $capitulo ?>">Capítulo <?= $capitulo ?></a>
				<?php endforeach; ?>
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
		<p><?= $livro->nome ?></p>
		<h3>Abreviado</h3>
		<p><?= $livro->abreviado ?></p>
		<h3>Posição</h3>
		<p><?= $livro->posicao ?></p>
		<h3>Capítulos</h3>
		<div class="horizontal link list ui">
			<?php foreach(range(1, $livro->capitulos) as $capitulo): ?>
			<a class="item" href="<?= VERSAO . $livro->abreviado . "/" . $capitulo ?>"><?= $capitulo ?></a>
			<?php endforeach; ?>
		</div>
		<h3>Sobre</h3>
		<p><?= $livro->sobre ?: "Ainda não temos informações sobre o livro." ?></p>
	</div>
	<?php endif; ?>
</div>
