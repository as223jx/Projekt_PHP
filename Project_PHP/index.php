<?php

require_once ("src/HTMLView.php");
require_once ("src/UploadController.php");
require_once ("src/UploadView.php");
require_once ("src/UploadModel.php");

// Startar session & sätter cookie hos klienten
session_start();

$c = new UploadController();

$htmlBody = $c->doUploadControll();

$view = new HTMLView();
$view->echoHTML($htmlBody);