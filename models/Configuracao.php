<?php

/**
 * Classe singleton de configurações do sistema
 *
 * @category Model
 */
class Configuracao {
	/**
	 * @var string $arquivo
	 */
	private static string $arquivo;

	/**
	 * @var array<string,array<string,string>> $conteudo
	 */
	public static array $conteudo;


	/**
	 * @param string $arquivo
	 *
	 * @return void
	 */
	public function __construct(string $arquivo="") {
		self::$arquivo = $arquivo;

		if(file_exists($arquivo) && empty(self::$conteudo)) {
			self::$conteudo = parse_ini_file($arquivo, true, INI_SCANNER_TYPED);
		}
	}


	/**
	 * @param string $atributo
	 * @param string $valor
	 * @param string $sessao
	 *
	 * @static
	 * @return void
	 */
	public static function set(string $atributo, string $valor, string $sessao=""): void {
		if($sessao !== "" && in_array($sessao, array_keys(self::$conteudo))) {
			self::$conteudo[$sessao] = array_merge(self::$conteudo[$sessao], [$atributo => $valor]);
		}
		elseif($sessao !== "") {
			self::$conteudo[$sessao] = [$atributo => $valor];
		}
		else {
			self::$conteudo[$atributo] = $valor;
		}
	}


	/**
	 * @param string $atributo
	 * @param string $sessao
	 *
	 * @static
	 * @return array<string,mixed>|bool|float|int|string
	 */
	public static function get(string $atributo, string $sessao=""): array|bool|float|int|string {
		if(empty(self::$conteudo) && file_exists(self::$arquivo)) {
			self::$conteudo = parse_ini_file(self::$arquivo, true, INI_SCANNER_TYPED);
		}

		return self::$conteudo[$sessao][$atributo] ?? self::$conteudo[$atributo] ?? null;
	}


	/**
	 * @param array<string,array<string,mixed>|bool|float|int|string> $conteudo
	 *
	 * @static
	 * @return string
	 */
	private static function recursive(array $conteudo): string {
		$texto = "";

		foreach($conteudo as $variavel => $valor) {
			if(is_array($valor)) {
				$texto .= "[" . $variavel . "]" . PHP_EOL . self::recursive($valor) . (end($conteudo) !== $valor ? PHP_EOL : "");
			}
			elseif(is_bool($valor)) {
				$texto .= $variavel . " = " . ($valor ? "true" : "false") . PHP_EOL;
			}
			else {
				$texto .= $variavel . " = " . $valor . PHP_EOL;
			}
		}

		return $texto;
	}


	/**
	 * @return bool
	 */
	public function save(): bool {
		return self::create(self::$arquivo);
	}


	/**
	 * @param string $arquivo
	 *
	 * @static
	 * @return bool
	 */
	public static function create(string $arquivo): bool {
		if(!empty(self::$conteudo)) {
			$texto = self::recursive(self::$conteudo);
			$fd = fopen($arquivo, "w");
			fwrite($fd, $texto);
			fclose($fd);
			return true;
		}

		return false;
	}


	/**
	 * @param string $arquivo
	 *
	 * @static
	 * @return self
	 */
	public static function ini(string $arquivo=__DIR__ . "/../biblia.ini"): self {
		return new self($arquivo);
	}


	/**
	 * @static
	 * @return self
	 */
	public static function refresh(): self {
		self::$conteudo = [];
		return new self(self::$arquivo);
	}
}
