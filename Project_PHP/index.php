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

$c = new UploadController();

$htmlBody = $c->doUploadControll($loggedIn);

$view = new HTMLView();
$view->echoHTML($loginC->getHTML(), $htmlBody, $loggedIn);