<?php

class HTMLView {
	
	private $uploadBtn = "";
	private $startUrl = "/Project_PHP";
	//private $loginoutBtn = "<form method='post'><input type='submit' name='login' id='loginoutBtn' value='Log in'></form>";
	//private $loginoutBtn = "";
	private $loginForm = "";
	
	public function echoHTML($loginBody, $body, $loggedInStatus){
		if ($body == NULL) {
			throw new \Exception("Body can't be null");
		}

		if($loggedInStatus == true){
			$this->uploadBtn = "<a href='?upload'><button>Upload image</button></a>";
			//$this->loginoutBtn = "<form method='post'><input type='submit' id='loginoutBtn' name='logout' value='Log out'></form>";
		}
		
		if(isset($_POST["login"])){
			$this->loginForm = "
			<form method='post' id='loginForm'>
			<label for='title'>Username:</label>
			<input type='text' name='username' id='username'>
			<label for='title'>Password:</label>
			<input type='password' name='password' id='password'>
			<input type='submit' name='loginSubmit' value='Submit'>
			</form>";
		}
		
		echo "
<!DOCTYPE html>
			<head>
			<meta charset='UTF-8'>
			<title>Portfolio - Alexandra Seppänen</title>
			<link rel='stylesheet' type='text/css' href='src/style.css'>
			<SCRIPT TYPE='text/javascript'>
			function newCategory(value){
				if(value == 'NewCategory'){
					var categoryTextfield = document.getElementById('categoryTextfield');
					var categoryLabel = document.getElementById('categoryLabel');
					categoryTextfield.style.visibility = 'visible';
					categoryLabel.style.visibility = 'visible';
				}
			}
			</SCRIPT>
			</head>
			<body>
				<div id='bodyDiv'>
				$loginBody

						$body
					</div>
				</div>
			</body>
		";
	}
}