<?php

$versoes ??= [];

?>

<div class="attached message ui">
	<h3 class="aligned center header icon ui">
		<i class="alternate calendar circular icon"></i>
		<div id="titulo">Versões</div>
		<small><?= count($versoes) === 1 ? "1 versao" : count($versoes) . " versões" ?></small>
	</h3>
</div>


<div class="container grid ui">
	<div class="attached fluid segment ui">
		<div class="horizontal link list ui">
		<?php foreach($versoes as $versao): ?>
			<a class="item" href="<?= $versao->abreviado ?>"><?= $versao->nome ?></a>
		<?php endforeach; ?>
		</div>
	</div>
</div>
