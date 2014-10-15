<?php

require_once ("src/HTMLView.php");
require_once ("src/UploadController.php");
require_once ("src/UploadView.php");
require_once ("src/UploadModel.php");
require_once ("src/LoginController.php");

// Startar session & sätter cookie hos klienten
session_start();

$loginC = new LoginController();
$loggedIn = $loginC->doLoginControll();

if($loggedIn == true){
	echo "Aaa";
}
else{
	echo "Bbb";
}

$c = new UploadController();

$htmlBody = $c->doUploadControll();

$view = new HTMLView();
$view->echoHTML($htmlBody, $loggedIn);