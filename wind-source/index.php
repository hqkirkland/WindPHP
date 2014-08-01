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
	
	include("global.php");	
	
	define("REQUIRE_LOGIN", false);

	
	if(isset($_POST["username"])) {
		
		$user->checkIn($_POST["username"], $_POST["password"]);
		
	}
	
	if(isset($_SESSION["username"])) {
	
		header("Location: /me.php");
		exit;
	
	}
	
	echo $page->preparePage("index");
	echo $page->preparePage("footer-tpl");


	
	
	?>