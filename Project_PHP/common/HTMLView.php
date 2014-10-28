<?php

class HTMLView {
	
	public function echoHTML($body){
		if ($body == NULL) {
			throw new \Exception("Body can't be null");
		}
		
		echo "
			<!DOCTYPE html>
			<meta charset='UTF-8'>
			<title>as223jx</title>
			<body>
				<h1>Laborationskod as223jx</h1>
				$body
			</body>
		";
	}
}