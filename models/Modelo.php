<?php

/**
 * Classe útil para extensão dos demais modelos
 *
 * @category Model
 */
abstract class Modelo {
	/**
	 * @var array<int,ReflectionProperty> $variaveis
	 */
	protected array $variaveis;


	/**
	 * @param ?self $modelo
	 *
	 * @return void
	 */
	public function __construct(?self $modelo=null) {
		$reflexao = new ReflectionClass(get_class($modelo));
		$this->variaveis = $reflexao->getProperties(ReflectionProperty::IS_PRIVATE);
	}


	/**
	 * @return array<string,mixed>
	 */
	public function json(): array {
		$retorno = [];

		foreach($this->variaveis as $variavel) {
			if(is_object($this->{$variavel->name})) {
				$retorno[$variavel->name] = $this->{$variavel->name}->json();
			}
			elseif(is_array($this->{$variavel->name})) {
				foreach($this->{$variavel->name} as $indice) {
					if(is_object($indice)) {
						$retorno[$variavel->name][] = $indice->json();
					}
					else {
						$retorno[$variavel->name][] = $indice;
					}
				}
			}
			else {
				$retorno[$variavel->name] = $this->{$variavel->name};
			}
		}

		return $retorno;
	}
}
