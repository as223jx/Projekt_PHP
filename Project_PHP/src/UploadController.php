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

		// Redigera bild
		if($this->view->didUserPressSave() && $loginStatus){
			if(!$this->view->checkIfEmptyTitle($this->view->getTitle())){
			$this->pic = new Pic($this->view->getPicToBeEdited(), $this->view->getTitle(), $this->view->getUrl(), $this->view->getDescription(), $this->view->getCategory());
			$this->view->setCookieMsg($this->model->updatePic($this->pic));
			$this->view->picHeader();
			}
		}
		
		if($this->view->didUserPressEdit() && $loginStatus){
			return $this->view->showEditForm();
		}
		
		// Radera bild
		if($this->view->didUserPressDelete() && $loginStatus){
			$this->model->deletePicFromFolder($this->view->getClickedPic());
			$this->view->setCookieMsg($this->model->deletePic($this->view->getClickedPic()));
			$this->view->viewAllHeader();
		}
		
		// Ladda upp ny bild
		if($this->view->didUserPressSubmit() && $loginStatus){
			$this->pic = new Pic(null, $this->view->getTitle(), $this->view->getUrl(), $this->view->getDescription(), $this->view->getCategory());
			//$this->model->addPic($this->pic);
			if($this->view->checkIfUniqueTitle($this->view->getTitle())){
				$url = $this->pic->getUrl();
					while($this->model->checkIfFileExists($url)){
						$url = $this->model->generateUniqueUrl($url);
					}
					if($this->model->checkIfValidExtension($url)){
						$this->pic = new Pic(null, $this->view->getTitle(), $url, $this->view->getDescription(), $this->view->getCategory());
						if($this->view->uploadToFolder($this->pic)){
							$this->model->addPicToDb($this->pic);	
							$this->view->getUploadFeedback($this->pic);
						}
						
					}
					else{
						$this->view->setMsg($this->invalidExtensionMsg);
					}
				
			}
			else{
				//$this->view->setMsg($this->notUniqueTitleMsg);
			}
			return $this->view->showUploadForm();
		}
		
		if($this->view->didUserPressUpload() && $loginStatus){
			return $this->view->showUploadForm();
		}
		
		// Visa bild
		if($this->view->picWasClicked()){
			if($this->view->getClickedPic() == null){
				return $this->view->showHTML();
			}
			return $this->view->showPicInfo($this->view->getClickedPic(), $loginStatus);
		}
		
		// Startsida
		return $this->view->showHTML();
	}
}
