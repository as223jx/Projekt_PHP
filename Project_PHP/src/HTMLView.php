<?php

class HTMLView {
	
	public function echoHTML($body){
		if ($body == NULL) {
			throw new \Exception("Body can't be null");
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
					<a href='?logOut'><button id='logoutBtn'>Log out</button></a>
					<div id='container'>
						<h1>Portfolio</h1>
						<h2>Alexandra Seppänen</h2>
						<div id='menu'>
						<a href='/Project_PHP'><button>Start</button></a>
						<a href='?viewAll'><button>View all</button></a>
						<a href='?upload'><button>Upload image</button></a>
						</div>
						$body
					</div>
				</div>
			</body>
		";
	}
}