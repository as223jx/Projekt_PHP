<?php

require_once("src/UploadModel.php");
require_once("src/UploadView.php");
require_once("src/Pic.php");

class UploadController{
	
	private $model;
	private $view;
	
	public function __construct(){
		$this->model = new UploadModel();
		$this->view = new UploadView($this->model);
	}
	
	public function doUploadControll($loginStatus){
		if($loginStatus){
			echo "logged in";
		}
		else{
			echo "logged out";
		}
		if($this->view->didUserPressEdit()){
			return $this->view->showEditForm();
		}
		
		if($this->view->didUserPressSubmit()){
			$pic = new Pic($this->view->getTitle(), $this->view->getUrl(), $this->view->getDescription(), $this->view->getCategory());
			$this->model->addPic($pic);
			$this->view->tryUpload();
			return $this->view->showUploadForm();
		}
		
		if($this->view->didUserPressUpload()){
			return $this->view->showUploadForm();
		}
				
		if($this->view->picWasClicked()){
			return $this->view->showPicInfo($this->view->getClickedPic(), $loginStatus);
		}

		return $this->view->showHTML();
	}
}
