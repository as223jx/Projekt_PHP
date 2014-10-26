<?php

require_once("src/UploadModel.php");
require_once("src/UploadView.php");
require_once("src/Pic.php");

class UploadController{
	
	private $model;
	private $view;
	private $pic;
	private $invalidExtensionMsg = "<p id='msg'>Invalid file extension!</p>";
	private $notUniqueTitleMsg = "<p>Title needs to be unique!</p>";
	
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
		
		// Redigera bild
		if($this->view->didUserPressSave()){
			$this->pic = new Pic($this->view->getPicToBeEdited(), $this->view->getTitle(), $this->view->getUrl(), $this->view->getDescription(), $this->view->getCategory());
			$this->view->setMsg($this->model->updatePic($this->pic));
			return $this->view->showPicInfo($this->pic->getId(), $loginStatus);
		}
		
		if($this->view->didUserPressEdit()){
			return $this->view->showEditForm();
		}
		
		// Radera bild
		if($this->view->didUserPressDelete()){
			$this->model->deletePicFromFolder($this->view->getClickedPic());
			$this->view->setMsg($this->model->deletePic($this->view->getClickedPic()));
			return $this->view->showHTML();
		}
		
		// Ladda upp ny bild
		if($this->view->didUserPressSubmit()){
			$this->pic = new Pic(null, $this->view->getTitle(), $this->view->getUrl(), $this->view->getDescription(), $this->view->getCategory());
			//$this->model->addPic($this->pic);
			if($this->view->checkIfUniqueTitle($this->view->getTitle())){
				$url = $this->pic->getUrl();
				
				if($this->model->checkIfFileExists($this->pic->getUrl())){
					$url = $this->model->generateUniqueUrl($this->pic->getUrl());
				}
				if($this->model->checkIfValidExtension($url)){
					$this->pic = new Pic(null, $this->view->getTitle(), $url, $this->view->getDescription(), $this->view->getCategory());
					$this->model->addPicToDb($this->pic);	
					$this->view->uploadToFolder($this->pic);
				}
				else{
					$this->view->setMsg($this->invalidExtensionMsg);
				}
			}
			else{
				$this->view->setMsg($this->notUniqueTitleMsg);
			}
			return $this->view->showUploadForm();
		}
		
		if($this->view->didUserPressUpload()){
			return $this->view->showUploadForm();
		}
		
		// Visa bild
		if($this->view->picWasClicked()){
			return $this->view->showPicInfo($this->view->getClickedPic(), $loginStatus);
		}
		
		// Startsida
		return $this->view->showHTML();
	}
}
