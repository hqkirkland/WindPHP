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
		
		
		// Notice: These variables should also match in Holo's system_config table to work!
		$hotel["server_address"] = "127.0.0.1";
		$hotel["server_port"] = "4000";
		$hotel["server_mus"] = "4001";
	
		
		$hotel["dcr_base"] = "http://dev.nodebay.com/v26/"; // Change this!
		$hotel["external_variables"] = "http://dev.nodebay.com/v26/external_variables.txt"; // Change this!
		$hotel["external_texts"] = "http://dev.nodebay.com/v26/external_texts.txt"; // Change this!
		
		
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
			"server_mus" => $hotel["server_mus"],
			"dcr_base" => $hotel["dcr_base"],
			"external_variables" => $hotel["external_variables"],
			"external_texts" => $hotel["external_texts"],
			"site_url" => $site["url"],
			"site_motto" => $site["motto"],
			"users_online" => $system["onlinecount"],
			"build_number" => "4024"
			
			);
			
		// If you want to add additional parameters for your username, see the user engine under the "checkIn();" function :)
		if(isset($_SESSION["user_id"])) {
		
			$params["username"] = $_SESSION["username"];
			$params["user_id"] = $_SESSION["user_id"];
			$params["auth_ticket"] = $_SESSION["auth_ticket"];
			$params["user_rank"] = $_SESSION["rank"];
		
		}
		
		
	
	?>