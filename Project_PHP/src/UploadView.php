<?php

require_once("src/UploadModel.php");

class UploadView{

	private $model;
	private $view;
	private $msg = "";
	private $picDir = "src/uploadedPics/";
	
	public function __construct(UploadModel $model){
		$this->model = $model;
	}
	
	public function picWasClicked(){
		$images = glob($this->picDir . "*.*");
		
		for($i = 0; $i < count($images); $i++){
			$href = str_replace("src/uploadedPics/", "", $images[$i]);

			if(isset($_GET["pic"])){
				return true;
			}
			else{
				return false;
			}
		}
	}
	
	public function getClickedPic(){
		return $_GET["pic"];
	}
	
	public function showHTML(){
		$images = glob($this->picDir . "*.*");
		$imageStr = "";
		$content = "";
		$ret = "";
		
		for($i = 0; $i < count($images); $i++){
			$href = str_replace("src/uploadedPics/", "", $images[$i]);
			$imageStr .= "<a href='?pic=" . $i ."'><img src='" . $images[$i] . "' class='image' /></a>";
		}
		
		if(isset($_GET["viewAll"])){
			$content = "<div id='imageDiv'>" . $imageStr . "</div>";
		}

		else{
			$content = "<div id='welcomeDiv'>
			<p>Välkommen till min portfolio! Lorem ipsum osv.</p>
			</div>";
		}
		
		$ret = "<div>
				<p>$this->msg</p>$content
				</div>";
		
		return $ret;
	}
	
	public function showPicInfo($picId){
		$ret = "";
			
		return $ret;
	}
	
	public function showUploadForm(){
		$ret = "";
		
		$ret = "<div><p>$this->msg</p><form method='post'
				enctype='multipart/form-data'>
				<label for='file'>Image to upload:</label>
				<input type='file' name='file' id='file'><br>
				<label for='title'>Image title:</label>
				<input type='text' name='title' id='text'><br>
				<label for='desc'>Description:</label>
				<input type='text' name='desc' id='desc'><br>
				<input type='submit' name='submit' value='Submit'>
				</form></div>";
				
		return $ret;
	}
	
	public function tryUpload(){
		$fileExtensions = array("jpeg", "jpg", "png");
		$filename = $_FILES["file"]["name"];
		$fileTmpName = $_FILES["file"]["tmp_name"];
		$extension = pathinfo($filename, PATHINFO_EXTENSION);
		
		$this->msg = $this->model->checkFileExtension($filename, $fileTmpName, $this->picDir);
	}
	
	public function didUserPressUpload(){
		if(isset($_GET["upload"])){
			return true;
		}
		else return false;
	}
	
	public function didUserPressSubmit(){
		if(isset($_POST["submit"])){
			return true;
		}
		return false;
	}
	
	public function getTitle(){
		if(isset($_POST["title"])){
			return $_POST["title"];
		}
		else return "";
	}
	
	public function getUrl(){
		if(isset($_FILES["file"])){
			return $_FILES["file"]["name"];
		}
		else return "";
	}
	
	public function getDescription(){
		if(isset($_POST["desc"])){
			return $_POST["desc"];
		}
		else return "";
	}
	
	public function getCategory(){
		return "Kategori";
	}
}
