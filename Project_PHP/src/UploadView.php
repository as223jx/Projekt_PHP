<?php

require_once("src/UploadModel.php");

class UploadView{

	private $model;
	private $view;
	private $msg = "";
	private $picDir = "src/uploadedPics/";
	// private static $id = "id";
	// private static $url = "url";
	// private static $description = "description";
	// private static $title = "title";
	
	public function __construct(UploadModel $model){
		$this->model = $model;
	}
	
	// public function showHTML(){
		// $picArr = $this->model->getAllPics();
		// $imageStr = "";
		// $content = "";
		// $ret = "";
		// $i = 0;
// 		
		// foreach($picArr as $pic){
			// $imageStr .= "<a href='?pic=" . $pic[self::$id] ."'><img src='src/uploadedPics/" . $pic[self::$url] . "' class='thumb' /></a>"; 
			// $i ++;
		// }
// 		
		// if(isset($_GET["viewAll"])){
			// $content = "<div id='imageDiv'>" . $imageStr . "</div>";
		// }
// 
		// else{
			// $content = "<div id='welcomeDiv'>
			// <p>Välkommen till min portfolio! Lorem ipsum osv.</p>
			// </div>";
		// }
// 		
		// $ret = "<div>
				// <p>$this->msg</p>$content
				// </div>";
// 		
		// return $ret;
	// }
// 	
	public function showHTML(){
		$picArr = $this->model->getAllPics();
		$imageStr = "";
		$content = "";
		$ret = "";
		$i = 0;
		
		foreach($picArr as $pic){
			$imageStr .= "<a href='?pic=" . $pic->getId() ."'><img src='src/uploadedPics/" . $pic->getUrl() . "' class='thumb' /></a>"; 
			//$i ++;
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
				<p id='msg'>$this->msg</p>$content
				</div>";
		
		return $ret;
	}
	
	public function showPicInfo($picId, $loginStatus){
		$pic = $this->model->getPicInfo($picId);
		$ret = "";
		if($loginStatus){
			$ret .= "<p><a href='?edit=$picId'><button>Edit</button></a>
			<form action = '' method = 'post'>
	        <input type='submit' name='delete' value='Delete' />
	    	</form></p>";
		}
		$ret .= "<p id='msg'>" . $this->msg . "</p><h3>" . $pic->getTitle() . "</h3><img src='src/uploadedPics/" . $pic->getUrl() . "' class='fullImage' /></a><p>" . $pic->getDescription() . "</p><p><b>Category:</b> " . $pic->getCategory() . "
		<p><a href='?viewAll'>Tillbaka</a></p>";
		return $ret;
	}
	
	public function showUploadForm(){
		$ret = "";
		$categoryStr = "";
	
		$categories = $this->model->getCategories();
		
		foreach($categories as $category){
			$categoryStr .= "<option value='". $category->getId() . "'>" . $category->getName() . "</option>";
		}
		
		$ret = "<div><p>$this->msg</p><form id='upload' method='post'
				enctype='multipart/form-data'>
				<label for='file'>Image to upload:</label>
				<input type='file' name='file' id='file'><br>
				<label for='title'>Image title:</label>
				<input type='text' name='title' id='text'><br>
				<label for='desc'>Description:</label>
				<textarea name='desc' id='desc' rows='10' cols='25'></textarea><br>
				<label for='category'>Category:</label>
				<select name='category' onChange='newCategory(this.value);'>
					$categoryStr
					<option value='NewCategory'>Ny kategori</option>
				</select><br>
				<label for='categoryTextfield' id='categoryLabel' class='hidden'>Ny kategori:</label>
				<input type='text' name='categoryTextfield' id='categoryTextfield' class='hidden'><br>
				<input type='submit' name='submit' value='Submit'>
				</form></div>";
				
		return $ret;
	}
	
	public function showEditForm(){
		$pic = $this->model->getPicInfo($_GET["edit"]);
		$ret = "";
		$categoryStr = "";
	
		$categories = $this->model->getCategories();
		
		foreach($categories as $category){
			$categoryStr .= "<option value='". $category->getId() . "'>" . $category->getName() . "</option>";
		}
		
		$ret = "<div><p id='msg'>$this->msg</p><img class='thumb' src='src/uploadedPics/" . $pic->getUrl() . "'><form id='upload' method='post'
				enctype='multipart/form-data'>
				<label for='title'>Image title:</label>
				<input type='text' name='title' id='text' value='" . $pic->getTitle() . "'><br>
				<label for='desc'>Description:</label>
				<textarea name='desc' id='desc' rows='10' cols='25'>" . $pic->getDescription() . "</textarea><br>
				<label for='category'>Category:</label>
				<select name='category' onChange='newCategory(this.value);'>
					$categoryStr
					<option value='NewCategory'>Ny kategori</option>
				</select><br>
				<label for='categoryTextfield' id='categoryLabel' class='hidden'>Ny kategori:</label>
				<input type='text' name='categoryTextfield' id='categoryTextfield' class='hidden'><br>
				<input type='submit' name='save' value='Save'>
				</form></div>";
				
		return $ret;
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
	
	public function tryUpload($url){
		$id = "";
		$pics = $this->model->getAllPics();
		foreach($pics as $pic){
			if($url == $pic->getUrl()){
				$id = $pic->getId();
			}
		}
		$this->msg = "<p id='msg'>" . $this->model->getFileUploadInfo() . "</p><a href='?pic=" . $id . "'>Show picture</a>";
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
	
	public function didUserPressSave(){
		if(isset($_POST["save"])){
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
	
	public function didUserPressDelete(){
		if(isset($_POST["delete"])){
			return true;
		}
		return false;
	}
	
	public function getPicToBeEdited(){
		if(isset($_GET["edit"])){
			return $_GET["edit"];
		}
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
		if(isset($_POST["category"])){
			
			if($_POST["category"] == "NewCategory" && isset($_POST["categoryTextfield"])){
				return $_POST["categoryTextfield"];
			}
			return $_POST["category"];
		}
		else return "";
	}
	
	public function setMsg($msg){
		$this->msg = $msg;
	}
}
