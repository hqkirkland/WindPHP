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
	
	namespace Whistler;
	
		class Page {
		
			final public function __construct() {
			
				global $mysqli;
				$this->mysqli = $mysqli;
				
			}
			
			final public function preparePage($tplId) {
				
				global $mysqli, $user;
				
				// If we're not on the index, since that will never require a login,
				if(!ON_INDEX) {
				
					// and if it does require a login, and a user is not logged in, send to the index page.
					if(REQUIRE_LOGIN == true && $user->checkLogin($_SESSION["username"]) == false) {
						
						header("Location: /index.php");
						exit;
						
					}
					
				}
				
				if(!file_exists("C:/inetpub/wwwroot/system/pages/" . $tplId .  ".pop")) {
		
					return "Stop messing around and get back to the hotel :@";
				
				}
				
				ob_start();
				include('C:/inetpub/wwwroot/system/pages/' . $tplId .  '.pop');
				$tpl = ob_get_contents();
				ob_end_clean();
				
				return $this->filterParams($tpl);
				
			}
			
			
			final public function filterParams($template) {
			
				global $params;
			
				foreach($params as $key => $value) {
				
					$template = str_ireplace('%' . $key . '%', $value, $template);
				
				}

				return $template;
			}
		
		}
	
	?>