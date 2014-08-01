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
				
			}
			
			final public function preparePage($tplId) {
				
				global $mysqli, $user;
				
				// and if it does require a login, and a user is not logged in, send to the index page.
				if(REQUIRE_LOGIN == true && !isset($_SESSION["username"]) && $user->checkLogin == false) {
					
					header("Location: /index.php");
					exit;
					
				}

				
				if(!file_exists("C:/inetpub/wwwroot/system/pages/" . $tplId .  ".pop")) {
		
					return "we 404 now :DDDDD";
				
				}
				
				ob_start();
				include("C:/inetpub/wwwroot/system/pages/" . $tplId .  ".pop");
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
			
			final public function unicodeToImage($str) {
			
				$search = array(
				
								'/\x{00a5}/u',
								'/\x{00aa}/u',
								'/\x{00ac}/u',
								'/\x{00b1}/u',
								'/\x{00b5}/u',
								'/\x{00b6}/u',
								'/\x{00ba}/u',
								'/\x{00bb}/u',
								'/\x{00d5}/u',
								'/\x{00f5}/u',
								'/\x{00f7}/u',
								'/\x{0192}/u',
								'/\x{2014}/u',
								'/\x{2020}/u',
								'/\x{2021}/u',
								'/\x{2022}/u'
								
								);
								
				$replace = array(
				
								'<img src="%url%/web-gallery/images/fonts/volter/165.gif" class="vchar" />',
								'<img src="%url%/web-gallery/images/fonts/volter/170.gif" class="vchar" />',
								'<img src="%url%/web-gallery/images/fonts/volter/172.gif" class="vchar" />',
								'<img src="%url%/web-gallery/images/fonts/volter/177.gif" class="vchar" />',
								'<img src="%url%/web-gallery/images/fonts/volter/181.gif" class="vchar" />',
								'<img src="%url%/web-gallery/images/fonts/volter/182.gif" class="vchar" />',
								'<img src="%url%/web-gallery/images/fonts/volter/186.gif" class="vchar" />',
								'<img src="%url%/web-gallery/images/fonts/volter/187.gif" class="vchar" />',
								'<img src="%url%/web-gallery/images/fonts/volter/213.gif" class="vchar" />',
								'<img src="%url%/web-gallery/images/fonts/volter/245.gif" class="vchar" />',
								'<img src="%url%/web-gallery/images/fonts/volter/247.gif" class="vchar" />',
								'<img src="%url%/web-gallery/images/fonts/volter/131.gif" class="vchar" />',
								'<img src="%url%/web-gallery/images/fonts/volter/151.gif" class="vchar" />',
								'<img src="%url%/web-gallery/images/fonts/volter/134.gif" class="vchar" />',
								'<img src="%url%/web-gallery/images/fonts/volter/135.gif" class="vchar" />',
								'<img src="%url%/web-gallery/images/fonts/volter/149.gif" class="vchar" />'
								
								);
								
				$str = preg_replace($search,$replace,$str);
				return $str;
				
			}
			
			final public function evenCheck($integer) {
			
				if($integer % 2 == 0) {
				
					return true;
					
				} 
					
				else {
				
					return false;
				
				}
			
			
			}
			
			final public function newsUrl($string) {
			
				trim(preg_replace('/\s\s+/',' ',preg_replace("/[^A-Za-z0-9-]/", " ", $string)));
				trim(preg_replace('/\s\s+/',' ',preg_replace("/[^A-Za-z0-9-]/", " ", $string)));
				strtolower($string)
				str_replace(" ", "-", $string);
				return $string;
		
			}
		
		}
	
	?>