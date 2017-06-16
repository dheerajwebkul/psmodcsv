<?php

class Db
{
	public static $dbhost = 'localhost';
	public static $dbuser = 'root';
	public static $dbpass = 'demo';
	public static $dbname = 'demo';

	public static function Connect()
	{
		$connect = mysqli_connect(self::$dbhost, self::$dbuser, self::$dbpass, self::$dbname);

		if (!$connect) {
		    echo "Error: Unable to connect to MySQL." . PHP_EOL;
		    echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
		    echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
		    exit;
		}

		return $connect;
	}
}