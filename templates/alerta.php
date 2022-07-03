<?php

$alerta ??= new Alerta;

?>

<div class="blue message ui" id="alerta" style="display: none;">
	<i class="close icon" id="botao-alerta"></i>
	<div class="header">
		<i class="icon info" id="icone-alerta"></i>
		<span id="cabecalho-alerta">
			<?= $alerta->titulo ?>
		</span>
	</div>
	<p id="texto-alerta"><?= $alerta->texto ?></p>
</div>
