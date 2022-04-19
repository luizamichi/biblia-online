<?php

$navegador ??= new Navegador;

?>

<div class="buttons ui">
	<button class="button <?= $navegador->anterior ?: "disabled" ?> icon labeled ui" href="<?= $navegador->anterior ?: "javascript:void(0)" ?>">
		<i class="chevron icon left"></i>
		Anterior
	</button>
	<button class="button ui violet">
		Página <?= $navegador->atual ?>
	</button>
	<button class="button <?= $navegador->proximo ?: "disabled" ?> icon labeled right ui" href="<?= $navegador->proximo ?: "javascript:void(0)" ?>">
		Próximo
		<i class="chevron icon right"></i>
	</button>
</div>
