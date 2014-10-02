<?php

require_once("src/UploadModel.php");
require_once("src/UploadView.php");

class UploadController{
	
	private $model;
	private $view;
	
	public function __construct(){
		$this->model = new UploadModel();
		$this->view = new UploadView($this->model);
	}
	
	public function doUploadControll(){
		
		if($this->view->didUserPressUpload()){
			return $this->view->showUploadForm();
		}
		if($this->view->didUserPressSubmit()){
			$this->model->tryUpload();
		}
		else
		return $this->view->showHTML();
	}
}
