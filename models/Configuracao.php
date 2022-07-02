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
	 * @var array<string,array<string,bool|float|int|string>|bool|float|int|string>
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
			/**
			 * @var array<string,array<string,bool|float|int|string>|bool|float|int|string>|false $ini
			 */
			$ini = parse_ini_file($arquivo, true, INI_SCANNER_TYPED);

			self::$conteudo = $ini !== false ? $ini : [];
		}
	}


	/**
	 * @param string $atributo
	 * @param bool|float|int|string $valor
	 * @param string $sessao
	 *
	 * @static
	 * @return void
	 */
	public static function set(string $atributo, bool|float|int|string $valor, string $sessao=""): void {
		if($sessao !== "") {
			if(isset(self::$conteudo[$sessao]) && is_array(self::$conteudo[$sessao])) {
				self::$conteudo[$sessao][$atributo] = $valor;
			}
			else {
				self::$conteudo[$sessao] = [$atributo => $valor];
			}
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
	 * @return array<string,bool|float|int|string>|bool|float|int|string|null
	 */
	public static function get(string $atributo, string $sessao=""): array|bool|float|int|string|null {
		if(empty(self::$conteudo) && file_exists(self::$arquivo)) {
			/**
			 * @var array<string,array<string,bool|float|int|string>|bool|float|int|string>|false $ini
			 */
			$ini = parse_ini_file(self::$arquivo, true, INI_SCANNER_TYPED);
			if(is_array($ini)) {
				self::$conteudo = $ini;
			}
		}

		if($sessao !== "" && isset(self::$conteudo[$sessao]) && is_array(self::$conteudo[$sessao])) {
			return self::$conteudo[$sessao][$atributo] ?? null;
		}

		return self::$conteudo[$atributo] ?? null;
	}


	/**
	 * @param string $atributo
	 * @param string $sessao
	 *
	 * @static
	 * @return string
	 */
	public static function getStr(string $atributo, string $sessao=""): string {
		$retorno = self::get($atributo, $sessao);
		return is_string($retorno) ? $retorno : "";
	}


	/**
	 * @param array<string,array<string,bool|float|int|string>|bool|float|int|string> $conteudo
	 *
	 * @static
	 * @return string
	 */
	private static function recursive(array $conteudo): string {
		$texto = "";

		foreach($conteudo as $variavel => $valor) {
			if(is_array($valor)) {
				$texto .= "[" . $variavel . "]" . PHP_EOL . self::recursive($valor) . PHP_EOL;
			}
			elseif(is_bool($valor)) {
				$texto .= $variavel . " = " . ($valor ? "true" : "false") . PHP_EOL;
			}
			else {
				$texto .= $variavel . " = " . strval($valor) . PHP_EOL;
			}
		}

		return rtrim($texto, PHP_EOL);
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

			if($fd) {
				fwrite($fd, $texto);
				fclose($fd);
			}

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
