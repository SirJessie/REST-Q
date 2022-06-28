<?php
	$servername = "localhost";
	$username = "root";
	$password = "";

	$conn = new mysqli($servername, $username, $password,   'rest-q_db');

	// Check connection
	if (!$conn) {
		die('Connection failed: ' . $conn->connect_error);
	}
?>