<?php

require_once("src/LoginModel.php");
require_once("src/LoginView.php");

class LoginController{
	private $model;
	private $view;
	
	public function __construct(){
		$this->model = new LoginModel();
		$this->view = new LoginView($this->model);
	}
	
	public function doLoginControll(){
		if($this->view->didUserPressLogout()){
			return false;
		}
		
		if($this->view->didUserPressLogin()){
			
			$username = $this->view->getUsernameInput();
			$password = $this->view->getPasswordInput();
			
			if($this->model->login($username, $password)){
				return true;
			}
			return false;
		}
		
		if($this->model->checkLoginStatus() == 1){
			return true;
		}
	}
}
