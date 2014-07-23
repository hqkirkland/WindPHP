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
	

	if(isset($_POST["bean_avatarName"])) {
	
		if((!isset($_POST["bean_figure"]) || !isset($_POST["bean_gender"])) && isset($_POST["randomFigure"])) {
		
			$_POST["bean_gender"] = substr($_POST["randomFigure"], 0, 1);
			$_POST["bean_figure"] = substr($_POST["randomFigure"], 2);
		
		}
		
		$user->insertUser($_POST["bean_avatarName"], $_POST["password"], $_POST["bean_email"], $_POST["bean_figure"],
						  $_POST["bean_gender"], $_POST["bean_day"], $_POST["bean_month"], $_POST["bean_year"]);
	}
	
	echo $page->preparePage("register");
	
	
	?>