<?php
	$host = 'localhost';
	$username = 'root';
	$password = '';
	$database = 'course_reg';

	$conn = mysqli_connect($host,$username,$password,$database);

	if(!$conn){
		echo "failed to connect to database";
	}
?>