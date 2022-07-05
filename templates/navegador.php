<?php

/**
 * @var ?Navegador $navegador
 */
$navegador ??= new Navegador;

?>

<div class="buttons ui">
	<button class="button icon labeled ui <?= $navegador->anterior ?: "disabled" ?>" href="<?= $navegador->anterior ?: "javascript:void(0)" ?>">
		<i class="arrow left icon"></i>
		Anterior
	</button>
	<button class="button ui violet">
		Página <?= $navegador->atual ?>
	</button>
	<button class="ui right labeled icon button <?= $navegador->proximo ?: "disabled" ?>" href="<?= $navegador->proximo ?: "javascript:void(0)" ?>">
		Próximo
		<i class="arrow right icon"></i>
	</button>
</div>
