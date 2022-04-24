<?php

require_once(__DIR__ . "/../autoload.php");


/**
 * Classe singleton de conexão ao banco de dados
 */
class Conexao extends PDO {
	/**
	 * @var int $id
	 * @var string $driver
	 * @var string $host
	 * @var string $schema
	 * @var string $username
	 * @var string $password
	 * @var int $port
	 * @var array $options
	 * @staticvar array $databases
	 */
	private int $id;
	private string $driver;
	private string $host;
	private string $schema;
	private string $username;
	private string $password;
	private int $port;
	private array $options;
	private static array $databases;

	/**
	 * @param string $driver
	 * @param string $host
	 * @param string $schema
	 * @param string $username
	 * @param string $password
	 * @param int $port
	 * @param array $options
	 * @return void
	 */
	public function __construct(string $driver="mysql", string $host="", string $schema="", string $username="", string $password="", int $port=3306, array $options=[PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]) {
		$this->driver = $driver;
		$this->host = $host;
		$this->schema = $schema;
		$this->username = $username;
		$this->password = $password;
		$this->port = $port;
		$this->options = $options;
		self::$databases ??= [];

		$dns = $this->driver . ":host=" . $this->host . ";port=" . $this->port . ";dbname=" . $this->schema;
		try {
			parent::__construct($dns, $username, $password, $options);
			self::$databases[] = $this;
			$this->id = count(self::$databases);
		}
		catch(PDOException $e) {
			if(Configuracao::ini()::get("debug", "project")) {
				debug_print_backtrace();
			}
			throw new PDOException("Não foi possível conectar na base de dados");
		}
	}


	/**
	 * @return void
	 */
	public function __destruct() {
		foreach(self::$databases as &$db) {
			$db = null;
		}
	}


	/**
	 * @return int
	 */
	public function id(): int {
		return $this->id;
	}


	/**
	 * @static
	 * @param array $configuracoes
	 * @return self
	 */
	public static function set(array $configuracoes): self {
		return new self(
			$configuracoes["driver"] ?? $configuracoes[0] ?? "mysql",
			$configuracoes["host"] ?? $configuracoes[1] ?? "",
			$configuracoes["schema"] ?? $configuracoes[2] ?? "",
			$configuracoes["username"] ?? $configuracoes[3] ?? "",
			$configuracoes["password"] ?? $configuracoes[4] ?? "",
			$configuracoes["port"] ?? $configuracoes[5] ?? 3306,
			$configuracoes["options"] ?? $configuracoes[6] ?? [PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
		);
	}


	/**
	 * @static
	 * @param int $indice
	 * @return self
	 */
	public static function get(int $indice=0): self {
		if(empty(self::$databases)) {
			$configuracao = Configuracao::ini();
			return new self(
				$configuracao::get("driver", "database"),
				$configuracao::get("host", "database"),
				$configuracao::get("schema", "database"),
				$configuracao::get("username", "database"),
				$configuracao::get("password", "database"),
				$configuracao::get("port", "database")
			);
		}

		return self::$databases[$indice - 1] ?? end(self::$databases) ?? null;
	}
}
