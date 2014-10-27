<?php

require_once("src/UploadModel.php");

class UploadView{

	private $model;
	private $view;
	private $msg = "";
	private $viewAll = "viewAll";
	private $category = "category";
	private $picDir = "src/uploadedPics/";
	
	
	public function __construct(UploadModel $model){
		$this->model = $model;
	}
	
	public function showHTML(){
		$imageStr = "";
		$content = "";
		$category = "";
		$lastCategory = "";
		$categoryStr = "";
		$ret = "";

		// Hämtar alla bilder och eventuellt sorterar om ett sorteringsalternativ är valt.		
		if(isset($_GET[$this->viewAll])){
			$picArr = $this->model->getAllPics($_GET[$this->viewAll]);
		}
		else{
			$picArr = $this->model->getAllPics(null);
		}
		
		// Sorteras bilderna efter kategori så skrivs en text ut som visar vilken kategori som ligger i det blocket.
		// Kategorinamnet byts när det en ny kategori dyker upp.
		foreach($picArr as $pic){
			if(isset($_GET[$this->viewAll]) && $_GET[$this->viewAll] == $this->model->getCategoryTable()){
				if($category != $pic->getCategory()){
					if($lastCategory == $pic->getCategory()){
						$category = "";
					}
					else{
						$categories = $this->model->getCategories();
						$category = $pic->getCategory();
						
						for($i = 0; count($categories) > $i; $i++){
							if($category == $categories[$i]->getId()){
								$categoryStr = "<div class='categories'><p>" . $categories[$i]->getName() . "</p></div>";
							}
						}
					}
				}
				else{
					$lastCategory = $category;
					$categoryStr = "";
				}
			}
			$imageStr .= $categoryStr. "<a href='?pic=" . $pic->getId() ."'><img src='src/uploadedPics/" . $pic->getUrl() . "' class='thumb' /></a>"; 
		}
		
		if(isset($_GET[$this->viewAll])){
			$content = "
				<div id='imageDiv'><div id='sort'><p>Sort by:	<a href='?viewAll=" . $this->model->getTitleTable() . "'>Title</a>
				<a href='?viewAll=" . $this->model->getCategoryTable() . "'>Category</a></p></div>

				" . $imageStr . "</div>";
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
		$ret = "<div id='imageDiv'>";
		if($loginStatus){
			$ret .= "<div id='editMenu'><p><a href='?edit=$picId'><button>Edit</button></a>
			<form action = '' method = 'post'>
	        <input type='submit' name='delete' value='Delete' />
	    	</form></p></div>";
		}
		$ret .= "<p id='msg'>" . $this->msg . "</p><h3>" . $pic->getTitle() . "</h3><img src='" . $this->picDir . $pic->getUrl() . "' class='fullImage' /></a><p>" . $pic->getDescription() . 
		"</p><p><b>Category:</b> " . $pic->getCategory() . " <p><a href='?viewAll'>Go to gallery</a></p></div>";
		return $ret;
	}
	
	public function showUploadForm(){
		$ret = "";
		$categoryStr = "";
		$title = "";
		$description = "";
	
		$categories = $this->model->getCategories();
		
		foreach($categories as $category){
			$categoryStr .= "<option value='". $category->getId() . "'>" . $category->getName() . "</option>";
		}
		if(!$this->model->checkIfFileExists($this->getUrl())){
			$title = $this->getTitle();
			$description = $this->getDescription();
		}
		
		$ret = "<div id='content'><p>$this->msg</p><form id='upload' method='post'
				enctype='multipart/form-data'>
				<label for='file'>Image to upload (Max filesize: 8 MB):</label><br>
				<input type='file' name='file' id='file'><br>
				<label for='title'>Image title:</label>
				<input type='text' name='title' id='text' value='" . $title . "'><br>
				<label for='desc'>Description:</label>
				<textarea name='desc' id='desc' rows='10' cols='25'>" . $description . "</textarea><br>
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
	
	public function uploadToFolder(Pic $pic){
		if($this->model->getFileUploadInfo($pic)){
			//$this->msg = "Image uploaded successfully! <br> <img src='". $this->picDir . $pic->getUrl() . "' class='thumb' />";
			return true;
		}
		$this->msg = "<p>Could not upload picture!</p>";
		return false;
	}
	
	public function getUploadFeedback(Pic $pic){
		$pics = $this->model->getAllPics(null);
		$id = "";
		foreach($pics as $existingPic){
			if($pic->getUrl() == $existingPic->getUrl()){
				$id = $existingPic->getId();
			}
		}
		
		$this->msg = "<p id='msg'>Image uploaded successfully! <br> <img src='". $this->picDir . $pic->getUrl() . "' class='thumb' /></p><a href='?pic=" . $id . "'>Show picture</a>";
	}
	
	public function checkIfUniqueTitle($title){
		if($title == null || strlen($title) < 1){
			$this->msg = "<p>Please choose a title!</p>";
			return false;
		}
			$pics = $this->model->getAllPics(null);
			foreach($pics as $pic){
				if(strtolower($title) == strtolower($pic->getTitle())){
					$this->msg = "<p>Please choose a unique title</p>";
					return false;
				}
			}
			return true;
	}
	
	public function getOrderByOption(){
		if(isset($_GET[$this->viewAll])){
			return $_GET[$this->viewAll];
		}
		return "";
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
