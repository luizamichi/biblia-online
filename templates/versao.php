<?php

require_once __DIR__ . "/../autoload.php";

/**
 * @var ?Versao $versao
 */
$versao ??= new Versao;

?>

<div class="attached message ui">
	<h3 class="aligned center header icon ui">
		<i class="alternate calendar circular icon"></i>
		<div data-title="<?= $versao->nome ?>" id="titulo">Versão</div>
		<small><?= $versao->abreviado ?></small>
	</h3>
</div>

<div class="container grid ui">
	<form action="api" class="attached fluid form segment ui" id="formulario-put" method="put">
		<input id="classe" name="classe" type="hidden" value="versao"/>
		<input id="chave" name="chave" type="hidden" value="<?= $versao->chave ?>"/>

		<div class="fields two">
			<div class="field">
				<label for="nome">Nome Completo</label>
				<input autofocus="autofocus" id="nome" maxlength="64" name="nome" placeholder="Nome Completo" required="required" type="text" value="<?= $versao->nome ?>"/>
			</div>
			<div class="field">
				<label for="abreviado">Nome Abreviado</label>
				<input id="abreviado" maxlength="8" name="abreviado" placeholder="Nome Abreviado" required="required" type="text" value="<?= $versao->abreviado ?>"/>
			</div>
		</div>

		<div class="field inline">
			<div class="checkbox ui">
				<input id="termos" type="checkbox">
				<label for="termos">Eu aceito modificar os valores da versão.</label>
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
</div>
