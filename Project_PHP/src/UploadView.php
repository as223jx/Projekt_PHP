<?php

require_once("src/UploadModel.php");

class UploadView{

	private $model;
	private $view;
	private $msg = "";
	private $viewAll = "viewAll";
	private $category = "category";
	private $picDir = "src/uploadedPics/";
	private $msgCookie = "msg";
	private static $pic = "pic";
	
	
	public function __construct(UploadModel $model){
		$this->model = $model;
		
		// Om ett message finns i msg-kakan så sätts det till variabeln $this->msg och töms från kakan.
		if(isset($_COOKIE[$this->msgCookie])){
			$this->msg = $_COOKIE[$this->msgCookie];
			setcookie($this->msgCookie, "", time() - 3600);
		}
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
		if(strlen($imageStr) < 1){
			$imageStr = "<p>No pics to show!</p>";
		}
		if(isset($_GET[$this->viewAll])){
			$content = "
				<div id='imageDiv'><div id='sort'><p>Sort by:	<a href='?viewAll=" . $this->model->getTitleTable() . "'>Title</a>
				<a href='?viewAll=" . $this->model->getCategoryTable() . "'>Category</a></p></div>

				" . $imageStr . "</div>";
		}
		
		// Om det inte är valt att visa galleriet så visas startsidan
		else{
			$content = "<div id='startDiv'>
			<p>Välkommen till min portfolio! Lorem ipsum osv.</p>
			</div>
			";
		}
		
		$ret = "<div id='wrapperDiv'>
				<p id='msg'>$this->msg</p>$content
				</div>";
		
		return $ret;
	}
	
	// Visar sidan och informationen för en enskild bild
	public function showPicInfo($picId, $loginStatus){
		$pic = $this->model->getPicInfo($picId);
		$ret = "<div id='imageDiv'>";
		
		// Om inloggad visas redigera och ta bort-alternativ
		if($loginStatus){
			$ret .= "
			<script>function validate(form){
					return confirm('Do you really want to delete the picture?');
				}
			</script>
			<div id='editMenu'><p><a href='?edit=$picId'><button>Edit</button></a>
			<form onsubmit='return validate(this);' action = '' method = 'post'>
	        <input type='submit' name='delete' value='Delete' />
	    	</form></p></div>";
		}
		$ret .= "<p id='msg'>" . $this->msg . "</p><h3>" . $pic->getTitle() . "</h3><img src='" . $this->picDir . $pic->getUrl() . "' class='fullImage' /></a><p>" . $pic->getDescription() . 
		"</p><p><b>Category:</b> " . $pic->getCategory() . " <p><a href='?viewAll'>Go to gallery</a></p></div>";
		return $ret;
	}
	
	// När admin vill ladda upp bild
	public function showUploadForm(){
		$ret = "";
		$categoryStr = "";
		$title = "";
		$description = "";
	
		// Hämtar ut existerande kategorier och lägger i dropdown-listan för kategorier
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
				<label for='file'>Image to upload:</label><br>
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
	
	// När admin vill redigera
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
	
	// Kollar om en bild har blivit klickad
	public function picWasClicked(){
			if(isset($_GET[self::$pic])){
				return true;
			}
			else{
				return false;
			}
	}
	
	// Returnerar bildens id som blivit klickad
	public function getClickedPic(){
		$pics = $this->model->getAllPics(null);
		$exists = false;
		foreach($pics as $pic){
			if($pic->getId() == $_GET[self::$pic]){
				$exists = true;
			}
		}
		if($exists){
			return $_GET[self::$pic];
		}
		else{
			return null;
		}
	}
	
	// Laddar upp till bildmappen
	public function uploadToFolder(Pic $pic){
		if($this->model->getFileUploadInfo($pic)){
			if($this->model->checkIfFileExists($pic->getUrl())){
				return true;
			}
		}
		$this->msg = "<p>File is too big!</p>";
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
	
	// Kollar om titeln som angetts innehåller något samt är unik
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
	
	public function checkIfEmptyTitle($title){
		if($title == null || strlen($title) < 1){
			$this->msg = "<p>Please choose a title!</p>";
			return true;
		}
	}
	
	// Kollar hur användaren vill sortera bilderna
	public function getOrderByOption(){
		if(isset($_GET[$this->viewAll])){
			return $_GET[$this->viewAll];
		}
		return "";
	}
	
	// Hyfsat självförklarande funktioner vv
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
	
	public function setCookieMsg($msg){
	    setcookie($this->msgCookie, $msg);
	}
	
	public function picHeader(){
		header ("Location: index.php?pic=" . $this->getPicToBeEdited());
	}
	
	public function viewAllHeader(){
		header ("Location: index.php?viewAll");
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
