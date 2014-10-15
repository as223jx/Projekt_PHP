<?php

class LoginModel{
	
	private $loggedInStatus = "loggedInStatus";
	
	public function __construct(){
		
	}
	
	public function checkLoginStatus(){
		if(!isset($_SESSION[$this->loggedInStatus])){
			$_SESSION[$this->loggedInStatus] = 0;
		}
		return $_SESSION[$this->loggedInStatus];
	}
	
	public function login($username, $password){

		if($username == "Admin" || $username == "admin" && $password == "Password"){
			$_SESSION[$this->loggedInStatus] = 1;
			return true;
		}
		return false;
	}
	
	public function logout(){
		$_SESSION[$this->loggedInStatus] = 0;
	}
}
