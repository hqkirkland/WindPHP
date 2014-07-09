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

	namespace Whistler;
	
		class Page {
		
			final public function __construct() {
			
				global $mysqli;
				$this->mysqli = $mysqli;
				
			}
			
			final public function preparePage($tplId) {
				
				global $mysqli;
				
				if($this->requireLogin) {
				
					header("Location: /index.php");
					exit;
					
				}
				
				else {
				
				
					if(!file_exists('C:/inetpub/wwwroot/system/pages/' . $tplId .  '.pop')) {
					
						return "Stop messing around and get back to the hotel :@<br /><br /> WE HAVE NOTHING TO HIDE LOL";
					
					}
				
					ob_start();
					include('C:/inetpub/wwwroot/system/pages/' . $tplId .  '.pop');
					$tpl = ob_get_contents();
					ob_end_clean();
					
					return $this->filterParams($tpl);
				
				}
				
			
			}
			
			final public function filterParams($template) {
			
				global $params;
				$this->params = $params;
			
				foreach($this->params as $key => $value) {
				
					$template = str_ireplace('%' . $key . '%', $value, $template);
				
				}

				return $template;
			}
		
		}
	
	?>