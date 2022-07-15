<?php

require_once __DIR__ . "/../autoload.php";


/**
 * Classe controladora de rotas
 *
 * @category Controller
 */
class RotaController {
	/**
	 * @static
	 * @return void
	 */
	public static function api(): void {
		include_once __DIR__ . "/../api.php";
	}


	/**
	 * @static
	 * @return void
	 */
	public static function login(): void {
		include_once __DIR__ . "/../login.php";
	}


	/**
	 * @static
	 * @return void
	 */
	public static function home(): void {
		$template = new Template("home");
		$template->titulo = Configuracao::ini()::getStr("system_name", "project");

		$tamanho = VersiculoDAO::length();
		$tamanho = max(1, $tamanho);
		$template->versiculoAleatorio = VersiculoDAO::chave(mt_rand(1, $tamanho));

		mt_srand((int) date("dmY"));
		$template->versiculoDiario = VersiculoDAO::chave(mt_rand(1, $tamanho));

		mt_srand((int) date("WmY"));
		$template->versiculoSemanal = VersiculoDAO::chave(mt_rand(1, $tamanho));

		mt_srand((int) date("mY"));
		$template->versiculoMensal = VersiculoDAO::chave(mt_rand(1, $tamanho));
		$template->body();
	}


	/**
	 * @param string $apelido
	 *
	 * @static
	 * @return void
	 */
	public static function autor(string $apelido): void {
		$autor = AutorDAO::apelido($apelido);
		$livros = LivroDAO::autor((int) $autor?->chave);

		$template = new Template("autor");
		$template->autor = $autor;
		$template->livros = $livros;
		$template->body();
	}


	/**
	 * @static
	 * @return void
	 */
	public static function autores(): void {
		$autores = AutorDAO::all();

		$template = new Template("autores");
		$template->autores = $autores;
		$template->body();
	}


	/**
	 * @param string $nome
	 *
	 * @static
	 * @return void
	 */
	public static function livro(string $nome): void {
		$livro = LivroDAO::abreviado($nome);
		$autores = AutorDAO::livro((int) $livro?->chave);

		$template = new Template("livro");
		$template->livro = $livro;
		$template->autores = $autores;
		$template->body();
	}


	/**
	 * @param string $testamento
	 *
	 * @static
	 * @return bool
	 */
	public static function livros(string $testamento=""): bool {
		$testamento = strtoupper($testamento);

		if(in_array($testamento, Sessao::testamentos())) {
			$testamento = TestamentoDAO::abreviado($testamento);
			self::testamento($testamento ?? new Testamento);
			return false;
		}
		else {
			$livros = LivroDAO::all();
		}

		$template = new Template("livros");
		$template->livros = $livros;
		$template->body();

		return true;
	}


	/**
	 * @param string $nome
	 * @param string $versao
	 * @param int $capitulo
	 *
	 * @static
	 * @return void
	 */
	public static function capitulo(string $nome, string $versao, int $capitulo): void {
		$capitulo = CapituloDAO::numeroLivroVersao($capitulo, $nome, $versao);

		$template = new Template("capitulo");
		$template->capitulo = $capitulo;
		$template->body();
	}


	/**
	 * @param string $versao
	 * @param string $livro
	 * @param int $capitulo
	 * @param int $numero
	 *
	 * @static
	 * @return void
	 */
	public static function versiculo(string $versao, string $livro, int $capitulo, int $numero): void {
		$capituloModel = CapituloDAO::numeroLivroVersao($capitulo, $livro, $versao);
		$versiculo = VersiculoDAO::versaoLivroCapituloNumero(
			$capituloModel->versiculos[0]->versao->chave ?? 0,
			$capituloModel->versiculos[0]->livro->chave ?? 0,
			$capitulo,
			$numero
		)
		?: new Versiculo(
			0,
			$capituloModel->versiculos[0]->versao ?? null,
			$capituloModel->versiculos[0]->livro ?? null,
			$capitulo,
			$numero
		);

		$template = new Template("versiculo");
		$template->versiculo = $versiculo;
		$template->body();
	}


	/**
	 * @param Testamento $testamento
	 *
	 * @static
	 * @return void
	 */
	public static function testamento(Testamento $testamento): void {
		$livros = LivroDAO::testamento($testamento->chave);

		$template = new Template("testamento");
		$template->testamento = $testamento;
		$template->livros = $livros;
		$template->body();
	}


	/**
	 * @static
	 * @return void
	 */
	public static function testamentos(): void {
		$testamentos = TestamentoDAO::all();

		$template = new Template("testamentos");
		$template->testamentos = $testamentos;
		$template->body();
	}


	/**
	 * @param string $abreviado
	 *
	 * @static
	 * @return void
	 */
	public static function versao(string $abreviado): void {
		$versao = VersaoDAO::abreviado($abreviado);

		$template = new Template("versao");
		$template->versao = $versao;
		$template->body();
	}


	/**
	 * @static
	 * @return void
	 */
	public static function versoes(): void {
		$versoes = VersaoDAO::all();

		$template = new Template("versoes");
		$template->versoes = $versoes;
		$template->body();
	}


	/**
	 * @param ?Throwable $excecao
	 *
	 * @static
	 * @return void
	 */
	public static function erro(?Throwable $excecao=null): void {
		$erro = ErroController::last();
		$template = new Template("erro");

		$template->descricao = $excecao?->getMessage() ?? $erro["message"] ?? "";
		$template->codigo = $excecao?->getCode() ?? $erro["type"] ?? 0;
		$template->linha = $excecao?->getLine() ?? $erro["line"] ?? 0;
		$template->local = $excecao?->getFile() ?? $erro["file"] ?? "";

		$template->body2();
	}


	/**
	 * @param string $arquivo
	 *
	 * @static
	 * @return void
	 */
	public static function files(string $arquivo): void {
		$extensao = pathinfo($arquivo, PATHINFO_EXTENSION);
		switch($extensao) {
			case "png":
				header("Content-Type: image/png");
				break;
			case "js":
				header("Content-type: text/javascript");
				break;
			case "css":
				header("Content-Type: text/css");
				break;
			default:
				header("Content-Type: text/plain");
				break;
		}

		include_once $arquivo;
	}
}
