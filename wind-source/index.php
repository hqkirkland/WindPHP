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

	include("global.php");
	
	define("REQUIRE_LOGIN", false);
	define("ON_INDEX", true);
	
	echo $page->preparePage("index");

	if(isset($_POST["username"])) {
	
	
	
	
		
		$user->checkIn($_POST["username"], $_POST["password"]);
		
	}
	
	
	
	
	?>