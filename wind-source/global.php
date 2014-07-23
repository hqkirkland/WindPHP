<?php

/*
														 
		___       ______       ________  ___  __  ______ 
		__ |     / /__(_)____________/ / __ \/ / / / __ \
		__ | /| / /__  /__  __ \  __  / /_/ / /_/ / /_/ /
		__ |/ |/ / _  / _  / / / /_/ / ____/ __  / ____/ 
		____/|__/  /_/  /_/ /_/\__,_/_/   /_/ /_/_/      
														  
	Copyright (C) 2014 
	written_by::programmer("hunter_kirkland");
	
	Released under GPL License v3 (See License.txt)

	If you change this program, you absolutely _MUST_ release
	these changes even if under a new name, /and/ retain credits.
	
	*/

	/* Configuration Section */
	
		// MySQLi	
		$mysqli_host = "localhost";
		$mysqli_user = "root";
		$mysqli_password = "*static-?827aj!zpAnkzsT{^ja";
		$mysqli_database = "shockwave";
		
		// Start MySQLi up here because we're going to use it sooner than I thought.
		$mysqli = new MySQLi($mysqli_host, $mysqli_user, $mysqli_password, $mysqli_database);
		
		
		// Site Options
		$site["url"] = "http://dev.nodebay.com"; // NO TRAILING "/"
		$site["motto"] = "Wind is a virtual hotel where you can hang out with your friends!";
		$site["cloudflare"] = false;
		$site["reverse_proxy"] = false;
		
		// Hotel Options
		$hotel["name"] = "Wind Hotel";
		$hotel["short_name"] = "Wind";
		$hotel["server_address"] = "127.0.0.1";
		$hotel["server_port"] = "4000";
		
		// Select more settings and data from the database
		$system = mysqli_fetch_array($mysqli->query("SELECT * FROM system"));

		
	/* Engine Section*/

			

		// Rev the engine..
		include("/system/class.page.php");
		include("system/class.user.php");
		
		use Whistler as Whistler;
		
		$page = new Whistler\Page();
		$user = new Whistler\User();
		
		// Set Parameters
		$params = Array(
			
			"hotel_name" => $hotel["name"],
			"short_name" => $hotel["short_name"],
			"server_ip" => $hotel["server_address"],
			"server_port" => $hotel["server_port"],
			"site_url" => $site["url"],
			"site_motto" => $site["motto"],
			"users_online" => $system["onlinecount"]
			
			);
			
		// If you want to add additional parameters for your username, see the user engine under the "checkIn();" function :)
		if(isset($_SESSION["user_id"])) {
		
			$params["username"] = $_SESSION["username"];
			$params["user_id"] = $_SESSION["user_id"];
			$params["auth_ticket"] = $_SESSION["auth_ticket"];
			$params["user_rank"] = $_SESSION["rank"];
		
		}
			
			
	
	?>