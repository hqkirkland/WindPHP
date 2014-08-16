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
		
		class User {
		
			final public function __construct() {
			
				global $mysqli;
				
				$this->mysqli = $mysqli;
				
			}
			
			final public function checkIn($username, $password) {
				
				global $mysqli;
				
				$filteredUsername = $mysqli->real_escape_string($username);
				
				$loginQuery = $mysqli->query("SELECT * FROM users WHERE name = '{$filteredUsername}'");
				$loginArray = mysqli_fetch_array($loginQuery);
				
				
				if(hash("sha256", $password) == $loginArray["password"]) {
					
					
					$banCheck = $this->checkBan($loginArray["name"], $_SERVER["REMOTE_ADDR"]);
					
					
					if($banCheck == false) {
					
						/* 
						Basically store the loginArray variables (all user data) in the session :) And, thus, the user is now logged in.
						If you wanted to add, say, credits to a session and then to a param, though this probably isn't wise since it will
						display the same number even if a change in credits is made, simply addd $_SESSION["credits"] = $loginArray["credits"]
						here, then add $params["credits"] = $_SESSION["credits"] in global.php
						*/
						
						
						$_SESSION["username"] = $loginArray["name"];
						$_SESSION["user_id"] = $loginArray["id"];
						$_SESSION["rank"] = $loginArray["rank"];
						$_SESSION["expire"] = time() + 43200;
						
						// Update the required fields.
						$mysqli->query("UPDATE users SET lastvisit = UNIX_TIMESTAMP(), ipaddress_last = '{$_SERVER["HTTP_X_FORWARDED_FOR"]}' WHERE name = '" . $loginArray["name"] . "'");
					
						header("Location: /me.php");
						exit;
						
					}
				
				}
				
				else {
				
					$_SESSION["pass_error"] = true;
				
				}
				
			}
			
			final public function insertUser($username, $password, $email, $figure, $gender, $day, $month, $year) {
			
				global $mysqli;
				
				// Escape all the input variables so that we don't let skiddies SQL inject.
				// Pretty pointless now, though, as everyone uses booters. Nevertheless, ESCAPE _ALL_ THE INPUT VARIABLES :D
				
				$username = $mysqli->real_escape_string($username);
				$password = hash("sha256", $mysqli->real_escape_string($password));
				$email = $mysqli->real_escape_string($email);
				$figure = $mysqli->real_escape_string($figure);
				$gender = $mysqli->real_escape_string($gender);
				
				$birthday = $month . "-" . $day . "-" . $year;
				$birthday = $mysqli->real_escape_string($birthday);
				
				if(!$mysqli->query("INSERT INTO users (name, password, email, rank, birth, hbirth, figure, sex, mission, credits, 
				tickets, lastvisit, online, guideavailable, shockwaveid, guide, window)
				VALUES ('{$username}', '{$password}', '{$email}', '1', '{$birthday}', '" . date("F j, Y, g:i a") . "', '{$figure}',
				'{$gender}', 'New User', '500', '100', " . time() . ", '0', '0', '0', '0', '0')")) {
				
					echo "ERROR: ".$mysqli->error;
					return false;
				
				}
				
				$this->checkIn($username, $password);
				return true;
			
			}
			
			final private function checkBan($username, $ipAddress) {
			
				global $mysqli;
				
				$userSelect = mysqli_fetch_array($mysqli->query("SELECT * FROM users WHERE name = '{$username}'"));
				$banSelect = $mysqli->query("SELECT * FROM users_bans WHERE userid = '" . $userSelect["id"] . "' OR ipaddress = '{$ipAddress}' ");
				$banNum = mysqli_num_rows($banSelect);
				
				while ($banArray = mysqli_fetch_assoc($banSelect)) {
					
					if (strtotime($banArray["date_expire"]) > time()) {
					
						$_SESSION["ban_desc"] = $banArray["descr"];
						$_SESSION["ban_dateExp"] = $banArray["date_expire"];
						
						return true;
						
					}

				}
				
				return false;
			
			}
			
			final public function checkLogin() {
			
				global $mysqli;
				
				// Making sure that a user's session is still active by adding 12 hours to their session timestamp,
				// and checking to make sure that that's still less than the time now, since everything in Habbo 
				// pretty much operates in UNIX timestamps.
				
				
				if($_SESSION["expire"] < time()) {
				
					return false;
					
				}
				
				else {
				
					return true;
				
				}
				
			}
			
			final public function get($column) {
			
				global $mysqli;
				
				$userQuery = $mysqli->query("SELECT * FROM users WHERE id = '{$_SESSION["user_id"]}'");
				$userArray = mysqli_fetch_array($userQuery);
				return $userArray[$column];
				
			
			}
			
			final public function getClubDays() {
			
				global $mysqli;
				// Credits to Meth0d for this function, PHPRetro: (/includes/data/Holograph.php)
				
				$clubQuery = $mysqli->query("SELECT * FROM users_club WHERE userid = '{$_SESSION["user_id"]}' ORDER BY date_monthstarted");
				$clubArray = mysqli_fetch_array($clubQuery);
				
				$monthsExp = $clubArray["months_expired"];
				$monthsLeft = $clubArray["months_left"];
				$dateStarted = $clubArray["date_monthstarted"];
				
				if(mysqli_num_rows($clubQuery) > 0) {
		
					$date = explode("-", $dateStarted);
					$day = $date[0];
					$month = $date[1];
					$year = $date[2];
					$difference = time() - mktime(0, 0, 0, $month, $day, $year, 0);
					
					if ($difference < 0) {
					
						$difference = 0;
						
					}
					
					$daysExp = floor($difference/60/60/24);
					
					return $monthsLeft * 31 - $daysExp;
					
				}
				
				else {
				
					return 0;
					
				}
	
			}

			final public function displayNotifications() {
			
				global $mysqli;

				$alertSql = $mysqli->query("SELECT * FROM cms_alerts WHERE userid = '{$_SESSION["user_id"]}' AND type > -1 ORDER BY id DESC");

				if(mysqli_num_rows($alertSql) > 0) {
				
					while($alertRow = mysqli_fetch_assoc($alertSql)) {
					
						if($alertRow['type'] == 2) {
						
							$heading = "Notification";
							
						}
						
						else {
						
							$heading = "New Message";
							
						}

						echo '<li id="feed-item-campaign" class="contributed">
								<a href="#" class="remove-feed-item" title="Hide notification">Hide Notification</a>
								<div>
									<b>' . $heading . '</b><br />' . nl2br($mysqli->real_escape_string($alertRow['alert']), true) . '
								</div>
							  </li>';
					
					}
					
				}
				
				$birthdate = $this->get("birth");
				$dateParts = explode("-", $birthdate);
				
				$day = $dateParts[0];
				$month2 = $dateParts[1];
				$year2 = $dateParts[2];
				
				if($day == date("d") && $month2 == date("m")) {
			
					echo '<li id="feed-birthday"><div>Happy birthday, %username%!</div></li>';
					
				}
				
				$reqQuery = mysqli_num_rows($mysqli->query("SELECT requestid FROM messenger_friendrequests WHERE userid_to = '{$_SESSION["user_id"]}'"));

				if($reqQuery != 0) {

					echo'<li id="feed-notification">You have <a href="%url%/client" onClick="HabboClient.openOrFocus(this); return false;">' . $reqQuery . '</a> Friend Requests</li>';
			
				}
			
		
				$cutoff = (time() - 1801);
				$friendQuery = $mysqli->query("SELECT * FROM messenger_friendships WHERE userid = '{$_SESSION["user_id"]}' OR friendid = '{$_SESSION["user_id"]}'");

				$friendCount = mysqli_num_rows($friendQuery);
				
				if(mysqli_num_rows($friendQuery) > 0) {

					echo '<li id="feed-friends">You have' . $friendCount . '</strong>friends online<span></span></li>';
	 
				}
	
			}
			
			final public function checkFuse($fuseStr) {
			
				global $mysqli;
				
				$rank = $this->get("rank");
				
				if(mysqli_num_rows($mysqli->query("SELECT * FROM system_fuserights WHERE min_rank <= '{$rank}' AND fuse = '{$fuseStr}'")) > 0) {
				
					return true;
				
				}
				
				return false;
			
			}

			
		}
		
		?>