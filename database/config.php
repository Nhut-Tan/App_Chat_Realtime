<?php
class Database_connection
{
	function connect()
	{
		$connect = new PDO("mysql:host=localhost; dbname=chatapp-realtime", "root", "");

		return $connect;
	}
}

?>