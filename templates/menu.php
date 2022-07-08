<?php

defined("VERSAO") ?: define("VERSAO", "");

?>

<div class="menu small stackable top ui">
	<div class="item">
		<img alt="Bíblia" src="images/biblia.png"/>
		<a href="<?= VERSAO ?>" style="color: inherit;">
			<h1>Bíblia Online</h1>
		</a>
	</div>
	<a class="item" href="<?= VERSAO ?>autores">
		Autores
	</a>
	<a class="item" href="<?= VERSAO ?>livros">
		Livros
	</a>
	<a class="item" href="<?= VERSAO ?>testamentos">
		Testamentos
	</a>
	<a class="item" href="<?= VERSAO ?>versoes">
		Versões
	</a>
	<div class="menu right">
		<div class="item">
			<form action="api" class="icon input transparent ui" id="formulario-get" method="get">
				<input name="classe" type="hidden" value="livro"/>
				<input name="campo" type="hidden" value="abreviado"/>
				<input class="prompt" id="consulta" name="consulta" placeholder="Procurar..." type="text"/>
				<i class="icon link search" id="procurar"></i>
			</form>
		</div>
		<div class="dropdown item ui">
			<i class="bars icon"></i>
			<div class="menu">
				<a class="item" href="javascript:void(0)" id="mudar-tema">
					<i class="adjust icon"></i>
					<span>Tema</span>
				</a>
				<a class="item" href="javascript:void(0)" id="aumentar-fonte">
					<i class="icon zoom-in"></i>
					<span>Aumentar Fonte</span>
				</a>
				<a class="item" href="javascript:void(0)" id="diminuir-fonte">
					<i class="icon zoom-out"></i>
					<span>Diminuir Fonte</span>
				</a>
				<div class="divider fitted ui"></div>
				<a class="item" href="javascript:void(0)" id="autenticar" style="display: <?= Operador::logged() ? "none" : "block" ?>;">
					<i class="alternate icon sign-in"></i>
					<span>Entrar</span>
				</a>
				<a class="item" href="javascript:void(0)" id="desautenticar" style="display: <?= Operador::logged() ? "block" : "none" ?>;">
					<i class="alternate icon sign-out"></i>
					<span>Sair</span>
				</a>
			</div>
		</div>
	</div>
</div>
