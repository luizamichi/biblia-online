<?php

require_once __DIR__ . "/../autoload.php";


/**
 * Classe singleton de conexões ao banco de dados
 *
 * @category Model
 */
class Conexao extends PDO {
	/**
	 * @var int $id
	 */
	private int $id;

	/**
	 * @var array<self> $databases
	 */
	private static array $databases;


	/**
	 * @param string $driver
	 * @param string $host
	 * @param string $schema
	 * @param string $username
	 * @param string $password
	 * @param int $port
	 * @param array<int,int> $options
	 *
	 * @return void
	 */
	public function __construct(private string $driver="mysql", private string $host="", private string $schema="", private string $username="", private string $password="", private int $port=3306, private array $options=[PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]) {
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
			parent::__construct($dns, $this->username, $this->password, $this->options);
			self::$databases[] = $this;
			$this->id = count(self::$databases);
		}
		catch(PDOException $_) {
			throw new PDOException("Não foi possível conectar na base de dados.");
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
	 * @param array<int|string,array<int,int>|int|string> $configuracoes
	 *
	 * @static
	 * @return self
	 */
	public static function set(array $configuracoes): self {
		$driver = $configuracoes["driver"] ?? $configuracoes[0];
		$host = $configuracoes["host"] ?? $configuracoes[1];
		$schema = $configuracoes["schema"] ?? $configuracoes[2];
		$username = $configuracoes["username"] ?? $configuracoes[3];
		$password = $configuracoes["password"] ?? $configuracoes[4];
		$port = $configuracoes["port"] ?? $configuracoes[5];
		$options = $configuracoes["options"] ?? $configuracoes[6];

		return new self(
			is_string($driver) ? $driver : "mysql",
			is_string($host) ? $host : "",
			is_string($schema) ? $schema : "",
			is_string($username) ? $username : "",
			is_string($password) ? $password : "",
			is_int($port) ? $port : 3306,
			is_array($options) ? $options : [PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
		);
	}


	/**
	 * @param int $indice
	 *
	 * @static
	 * @return self
	 */
	public static function get(int $indice=0): self {
		if(empty(self::$databases)) {
			$configuracao = Configuracao::ini();
			$driver = $configuracao::get("driver", "database");
			$host = $configuracao::get("host", "database");
			$schema = $configuracao::get("schema", "database");
			$username = $configuracao::get("username", "database");
			$password = $configuracao::get("password", "database");
			$port = $configuracao::get("port", "database");

			return new self(
				is_string($driver) ? $driver : "mysql",
				is_string($host) ? $host : "",
				is_string($schema) ? $schema : "",
				is_string($username) ? $username : "",
				is_string($password) ? $password : "",
				is_int($port) ? $port : 3306
			);
		}

		return self::$databases[$indice - 1] ?? end(self::$databases);
	}
}
