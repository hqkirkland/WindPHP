<?php
/*
	
		___       ______       ________  ___  __  ______   
		__ |     / /__(_)____________/ / __ \/ / / / __ \
		__ | /| / /__  /__  __ \  __  / /_/ / /_/ / /_/ /
		__ |/ |/ / _  / _  / / / /_/ / ____/ __  / ____/ 
		____/|__/  /_/  /_/ /_/\__,_/_/   /_/ /_/_/      

   \\		Copyright (C) 2014 
	\\		written_by::programmer("hunter_kirkland");
	
	Released under GPL License v3 (See License.txt) */
	
	class Page{
		
		public $mysqli;
		
		final public function __construct($mysqli) {
		
			$this->mysqli = $mysqli;
			$this->mysqli->query("UPDATE users SET name = 'Hunt2' WHERE name = 'Hunter'");
		
		}
		
	
	}