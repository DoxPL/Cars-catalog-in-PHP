<?php
require_once("config.php");
class MysqlDB
{
	//dane do polaczenia z baza MySQL
	private $dbhost, $dbusr, $dbpass, $dbname;
	public $conn;
	public function __construct($host, $user, $pass, $db)
	{
		$this->dbhost = $host;
		$this->dbusr = $user;
		$this->dbpass = $pass;
		$this->dbname = $db;
	}
	public function connect()
	{

		$link = new mysqli($this->dbhost, $this->dbusr, $this->dbpass, $this->dbname);
		if($link->connect_error)
		{
			throw new Exception ("Nie można połączyć się z bazą danych");
		}
		else
		{
			$this->conn = $link;
		}
	}
	
	public function cls()
	{
		$this->conn->close();
	}
	
}
$mysql = new MysqlDB($host, $user, $pass, $dbname);
?>