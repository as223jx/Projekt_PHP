<?php

class HTMLView {
	
	private $uploadBtn = "";
	private $startUrl = "/Project_PHP";
	private $loginoutBtn = "<form method='post'><input type='submit' name='login' id='loginoutBtn' value='Log in'></form>";
	private $loginForm = "";
	
	public function echoHTML($body, $loggedInStatus){
		if ($body == NULL) {
			throw new \Exception("Body can't be null");
		}

		if($loggedInStatus == true){
			$this->uploadBtn = "<a href='?upload'><button>Upload image</button></a>";
			$this->loginoutBtn = "<form method='post'><input type='submit' id='loginoutBtn' name='logout' value='Log out'></form>";
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
			</head>
			<body>
				<div id='bodyDiv'>
					$this->loginoutBtn
					$this->loginForm
					<div id='container'>
						<h1>Portfolio</h1>
						<h2>Alexandra Seppänen</h2>
						<div id='menu'>
						<a href='$this->startUrl'><button>Start</button></a>
						<a href='?viewAll'><button>View all</button></a>
						$this->uploadBtn
						</div>
						$body
					</div>
				</div>
			</body>
		";
	}
}