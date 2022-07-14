<?php

require_once __DIR__ . "/../autoload.php";


/**
 * Classe complementar de capítulos
 *
 * @category DAO
 */
class CapituloDAO {
	/**
	 * @param int $numero
	 * @param string $livroAbreviado
	 * @param string $versaoAbreviado
	 *
	 * @static
	 * @return Capitulo
	 */
	public static function numeroLivroVersao(int $numero, string $livroAbreviado, string $versaoAbreviado): Capitulo {
		$livro = LivroDAO::abreviado($livroAbreviado);
		$versao = VersaoDAO::abreviado($versaoAbreviado);
		$capitulo = new Capitulo($numero);

		$capitulo->versiculos = VersiculoDAO::versaoLivroCapitulo((int) $versao?->chave, (int) $livro?->chave, $capitulo->numero)
		?: [new Versiculo(0, $versao, $livro, $numero)];

		return $capitulo;
	}


	/**
	 * @param Capitulo $capitulo
	 *
	 * @static
	 * @return bool
	 */
	public static function update(Capitulo $capitulo): bool {
		$consulta = "";
		$parametros = [];

		foreach($capitulo->versiculos as $versiculo) {
			$consulta .= "UPDATE `versiculos`
                             SET `versiculo_versao_id` = :versiculo_versao_id{$versiculo->chave},
                                 `versiculo_livro_id` = :versiculo_livro_id{$versiculo->chave},
                                 `versiculo_capitulo` = :versiculo_capitulo{$versiculo->chave},
                                 `versiculo_numero` = :versiculo_numero{$versiculo->chave},
                                 `versiculo_texto` = :versiculo_texto{$versiculo->chave}
                           WHERE `versiculo_id` = :versiculo_id{$versiculo->chave};";
			$parametros[] = [
				[":versiculo_versao_id" . $versiculo->chave, $versiculo->versao?->chave, PDO::PARAM_INT],
				[":versiculo_livro_id" . $versiculo->chave, $versiculo->livro?->chave, PDO::PARAM_INT],
				[":versiculo_capitulo" . $versiculo->chave, $versiculo->capitulo, PDO::PARAM_INT],
				[":versiculo_numero" . $versiculo->chave, $versiculo->numero, PDO::PARAM_INT],
				[":versiculo_texto" . $versiculo->chave, $versiculo->texto, PDO::PARAM_STR],
				[":versiculo_id" . $versiculo->chave, $versiculo->chave, PDO::PARAM_INT]
			];
		}

		return VersiculoDAO::postAll($consulta, $parametros);
	}
}
