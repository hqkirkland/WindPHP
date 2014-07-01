<?php
/*
	
		___       ______       ________  ___  __  ______   
		__ |     / /__(_)____________/ / __ \/ / / / __ \
		__ | /| / /__  /__  __ \  __  / /_/ / /_/ / /_/ /
		__ |/ |/ / _  / _  / / / /_/ / ____/ __  / ____/ 
		____/|__/  /_/  /_/ /_/\__,_/_/   /_/ /_/_/      

	Copyright (C) 2014 
	written_by::programmer("hunter_kirkland");
	
	Released under GPL License v3 (See License.txt) */


	/* Configuration Section */
	
	$mysqli_host = "localhost";
	$mysqli_user = "root";
	$mysqli_password = "*static-?827aj!zpAnkzsT{^ja";
	$mysqli_database = "shockwave";
	
	$hotel["url"] = "http://dev.nodebay.com"; // No trailing "/" please.
	$hotel["server_address"] = "127.0.0.1";
	$hotel["server_port"] = "4000";


	
	/* Global Section */
	$mysqli = new MySQLi($mysqli_host, $mysqli_user, $mysqli_password, $mysqli_database);
	
	include("/system/class.page.php");
	$page = new Page($mysqli);
	


	
	?>