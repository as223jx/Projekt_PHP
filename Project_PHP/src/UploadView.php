<?php

require_once("src/UploadModel.php");

class UploadView{

	private $model;
	private $view;
	private $msg = "";
	private $picDir = "src/uploadedPics/";
	private static $id = "id";
	private static $url = "url";
	private static $description = "description";
	private static $title = "title";
	
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
		$picArr = $this->model->getAllPics();
		$imageStr = "";
		$content = "";
		$ret = "";
		$i = 0;
		
		foreach($picArr as $pic){
			$imageStr .= "<a href='?pic=" . $pic[self::$id] ."'><img src='src/uploadedPics/" . $pic[self::$url] . "' class='thumb' /></a>"; 
			$i ++;
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
	
	public function showPicInfo($picId, $loginStatus){
		$pic = $this->model->getPicInfo($picId);
		$ret = "";
		if($loginStatus){
			$ret .= "<p><a href='?edit=$picId'>Redigera</a> <a href=''>Radera</a></p>";
		}
		$ret .= "<h3>" . $pic[self::$title] . "</h3><img src='src/uploadedPics/" . $pic[self::$url] . "' class='fullImage' /></a><p>" . $pic[self::$description] . "</p><p><b>Category:</b> " . $pic["category"] . "
		<p><a href='?viewAll'>Tillbaka</a></p>";
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
				<textarea name='desc' id='desc' rows='10' cols='25'></textarea><br>
				<input type='submit' name='submit' value='Submit'>
				</form></div>";
				
		return $ret;
	}
	
	public function showEditForm(){
		$pic = $this->model->getPicInfo($_GET["edit"]);
		$ret = "";
		
		$ret = "<div><p>$this->msg</p><img class='thumb' src='src/uploadedPics/" . $pic[self::$url] . "'><form method='post'
				enctype='multipart/form-data'>
				<label for='title'>Image title:</label>
				<input type='text' name='title' id='text' value='" . $pic[self::$title] . "'><br>
				<label for='desc'>Description:</label>
				<textarea name='desc' id='desc' rows='10' cols='25'>" . $pic[self::$description] . "</textarea><br>
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
		return false;
	}
	
	public function didUserPressSubmit(){
		if(isset($_POST["submit"])){
			return true;
		}
		return false;
	}
	
	public function didUserPressEdit(){
		if(isset($_GET["edit"])){
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
