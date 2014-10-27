<?php

require_once("src/LoginModel.php");

class LoginView{
	private $model;
	private $startUrl = "/Project_PHP";
	private $msg = "hej";
	private $uploadBtn = "";
	
	public function __construct(LoginModel $model){
		$this->model = $model;
	}
	
	public function getHTML(){
			$ret = "";
			$this->loginoutBtn = "<form method='post'><input type='submit' name='login' id='loginoutBtn' value='Log in'></form>";
		if($this->model->checkLoginStatus() == 1){
			$this->uploadBtn = "<a href='?upload'><button>Upload image</button></a>";
			$this->loginoutBtn = "<form method='post'><input type='submit' id='loginoutBtn' name='logout' value='Log out'></form>";
		}
		if($this->didUserPressLogin()){
			$ret .= "<form method='post' id='loginForm'>
			<label for='title'>Username:</label>
			<input type='text' name='username' id='username'>
			<label for='title'>Password:</label>
			<input type='password' name='password' id='password'>
			<input type='submit' name='loginSubmit' value='Submit'>
			</form>";
		}
		$ret .= "
			$this->loginoutBtn
			<div id='container'>
				<div id='header'>
					<h1>Portfolio</h1>
					<h3>Alexandra Seppänen</h3>
					<div id='menu'>
						<a href='$this->startUrl'><button>Start</button></a>
						<a href='?viewAll'><button>Gallery</button></a>
						$this->uploadBtn
					</div>
				</div>";
		return $ret;
	}
	
	public function didUserPressLoginSubmit(){
		if(isset($_POST["loginSubmit"])){
			return true;
		}
		return false;
	}
	
	public function didUserPressLogin(){
		if(isset($_POST["login"])){
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
