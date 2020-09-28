<?php


class Config
{
	public static function getDBConnect()
	{
		$dsn = "mysql:host=localhost;dbname=GameConsole;port=3306;CHARACTER=utf8";
		$dbid = 'root';
		$dbpasswd = '';
		$dbh = new PDO($dsn, $dbid, $dbpasswd) or die(mysqli_connect_error());
		$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		return $dbh;
	}
}
