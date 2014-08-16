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
	
	include("../../global.php");
	
	$username = $mysqli->real_escape_string($_POST["name"]);
	$nameQuery = $mysqli->query("SELECT * FROM users WHERE name = '" . $username . "'");
	
	$filter = preg_replace("/[^a-z\d\-=\?!@:\.]/i", "", $username);

	if(mysqli_num_rows($nameQuery) > 0) {
	
		header("X-JSON: {\"registration_name\":\"Username Taken!\"}");
		exit;
		
	}
	
	elseif($filter != $username) {
	
		header("X-JSON: {\"registration_name\":\"Invalid Characters!\"}");
		exit;
		
	}
	
	elseif(strlen($username) > 24) {
	
		header("X-JSON: {\"registration_name\":\"Username too long!\"}");
		exit;
		
	}
	
	elseif(strlen($username) < 3) {
	
		header("X-JSON: {\"registration_name\":\"Username too short!\"}");
		exit;
		
	}
	
	elseif(strnatcasecmp(substr($username, 0, 4), "MOD-") == false && strnatcasecmp(substr($username, 0, 4))) {
	
		header("X-JSON: {\"registration_name\":\"Yeah, like we would fall for that, MOD-" . $username . "!\"}");
		exit;
		
	}
		
	else {
	
		header("X-JSON: {}");
		exit;
		
	}
	

	?>