<?php
	class DBConnection {

		public static function getConnection() {
			$servername = "localhost";
			$username = "id7115178_atdev";
			$password = "abc--123";
			$dbname = "id7115178_comic";
			// Create connection
			return new mysqli($servername, $username, $password,$dbname);
		}
	}
?>