<?php
class DB {
	// Configuration information:
	private static $user = 'root';
	private static $pass = '';
	private static $server = 'localhost';
	private static $dbname = 'bicis';

	public static function getConnection() {
		$connection = mysqli_connect(self::$server, self::$user, self::$pass);
        mysqli_select_db($connection,self::$dbname);
		// If we never connected to any database, throw an exception:
		if (!$connection)
			throw new Exception("Failed: localhost database");

		mysqli_set_charset($connection, 'utf8');
		mysqli_query($connection, 'SET sql_safe_updates=0');

		return $connection;
	}
}

function Conectar() {
	return DB::getConnection();
}

function Desconectar($con) { 
	$con->close();
}
?>