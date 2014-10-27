<?php

require_once ("adminLogin/HTMLView.php");
require_once ("adminLogin/LoginController.php");
require_once ("adminLogin/LoginView.php");
require_once ("adminLogin/LoginModel.php");

// Startar session & sätter cookie hos klienten
session_start();

$c = new LoginController();
$htmlBody = $c->doControll();

$view = new HTMLView();
$view->echoHTML($htmlBody);
