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
	
	public function showHTML(){
		$images = glob($this->picDir . "*.*");
		$imageStr = "";
		$content = "";
		$ret = "";
		
		foreach($images as $image){
			$imageStr .= "<img src='" . $image . "' class='image' />";
		}
		
		if(isset($_GET["viewAll"])){
			$content = "<div id='imageDiv'>" . $imageStr . "</div>";
		}
		else{
			$content = "<div id='welcomeDiv'>
			<p>Välkommen till min portfolio!
			<br>Jättefin info.
			<br>Massa info.
			<br>Eller något annat, jag låter ödet bestämma.
			<br>Med ödet menar jag att jag bestämmet mig sen vad som ska finnas här.
			<br><br>Tack!</p>
			</div>";
		}
		
		$ret = "<div>
				<p>$this->msg</p>$content
				</div>";
		
		return $ret;
	}
	
	public function showUploadForm(){
		// if(isset($_FILES["file"])){
			// $this->tryUpload();
		// }
		
		if(isset($_POST["submit"])){
			$this->tryUpload();
		}
		
		$ret = "";
		
		$ret = "<div><p>$this->msg</p><form method='post'
				enctype='multipart/form-data'>
				<label for='file'>Image to upload:</label>
				<input type='file' name='file' id='file'><br>
				<input type='submit' name='submit' value='Submit'>
				</form></div>";
				
		return $ret;
	}
	
	public function tryUpload(){
		$fileExtensions = array("jpeg", "jpg", "png");
		$filename = $_FILES["file"]["name"];
		$extension = pathinfo($filename, PATHINFO_EXTENSION);
		
		if(!in_array($extension, $fileExtensions)){
			$this->msg = "Invalid file";
			return false;
		}
		else{
			if(file_exists("src/uploadedPics/" . $_FILES["file"]["name"])){
				$this->msg = "File already exists";
			}
			else{
				move_uploaded_file($_FILES["file"]["tmp_name"], $this->picDir . $filename);
				$this->msg = "'" . $filename . "' uploaded successfully! <br> <img src='". $this->picDir . $filename . "' class='image' />";
			}
		
		}
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
}
