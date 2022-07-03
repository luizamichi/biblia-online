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
		$reflexao = new ReflectionClass($modelo ?? $this);
		$this->variaveis = $reflexao->getProperties(ReflectionProperty::IS_PRIVATE);
	}


	/**
	 * @return array<int,ReflectionProperty>
	 */
	public function variaveis(): array {
		return $this->variaveis;
	}


	/**
	 * @return array<string,mixed>
	 */
	public function json(): array {
		/**
		 * @var array<string,mixed> $retorno
		 */
		$retorno = [];

		foreach($this->variaveis as $variavel) {
			/**
			 * @var string $nome
			 */
			$nome = $variavel->name;

			/**
			 * @var array<int|string,mixed>|mixed|Modelo $valor
			 */
			$valor = $this->{$nome};

			if($valor instanceof Modelo) {
				$retorno[$nome] = $valor->json();
			}
			elseif(is_array($valor)) {
				/**
				 * @var array<mixed> $lista
				 */
				$lista = [];

				foreach($valor as $indice) {
					if($indice instanceof Modelo) {
						$lista[] = $indice->json();
					}
					else {
						$lista[] = $indice;
					}
				}

				$retorno[$nome] = $lista;
			}
			else {
				$retorno[$nome] = $valor;
			}
		}

		return $retorno;
	}
}
