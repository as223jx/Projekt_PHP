<?php

require_once("src/LoginModel.php");
require_once("src/LoginView.php");

class LoginController{
	private $model;
	private $view;
	private $startUrl = "/Project_PHP";
	private $msg = "hej";
	private $uploadBtn = "";
	
	public function __construct(){
		$this->model = new LoginModel();
		$this->view = new LoginView($this->model);
	}
	
	public function getHTML(){
		return $this->view->getHTML();
	}
	
	public function doLoginControll(){
		if($this->view->didUserPressLogout()){
			return false;
		}
		
		if($this->view->didUserPressLoginSubmit()){
			
			$username = $this->view->getUsernameInput();
			$password = $this->view->getPasswordInput();
			
			if($this->model->login($username, $password)){
				return true;
			}
			echo "<p id='loginMsg'>Wrong username or password</p>";
			return false;
		}
		
		if($this->model->checkLoginStatus() == 1){
			return true;
		}
	}
	
	public function checkLoginStatus(){
		if($this->model->checkLoginStatus() == 1){
			return true;
		}
		return false;
	}
	

}
