<?php

require_once("src/LoginModel.php");

class LoginView{
	private $model;
	
	public function __construct(LoginModel $model){
		$this->model = $model;
	}
	
	public function didUserPressLogin(){
		if(isset($_POST["loginSubmit"])){
			return true;
		}
		return false;
	}
	
	public function didUserPressLogout(){
		if(isset($_POST["logout"])){
			$this->model->logout();
			return true;
		}
		return false;
	}
	
	public function getUsernameInput(){
		if(isset($_POST["username"])){
			return $_POST["username"];
		}
		else return "Inget";
	}
	
		
	public function getPasswordInput(){
		if(isset($_POST["password"])){
			return $_POST["password"];
		}
		else return "Inget";
	}
}
