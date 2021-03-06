<?php

require_once("src/connectionSettings.php");
require_once("src/Pic.php");
require_once("src/Category.php");

class UploadModel{

	protected $dbConnection;
	protected $dbTable = "pics";
	protected $dbTableCategories = "categories";
	private $msg = "Msg";
	private $db = "";
	private $title = "title";
	private $url = "url";
	private $description = "description";
	private $category = "category";
	private $id = "id";
	private $picDir = "src/uploadedPics/";
	private static $sTitle = "title";
	private static $sUrl = "url";
	private static $sDescription = "description";
	private static $sCategory = "category";
	private static $sId = "id";
	private static $sCategoryName = "categoryName";
		
	public function __construct(){
		$this->db = $this->connection();
		chmod($this->picDir, 755);
	}

	// Lägger till uppladdad blid i databasen.
	public function addPicToDb(Pic $pic) {
		if($this->checkIfFileExists($pic->getUrl())){
			$categoryId = $this->checkIfNewCategory($pic);
			
			// Lägger in bilden med all info i databasen.
			try{
		    	$sql = "INSERT INTO $this->dbTable (" . self::$sTitle . ", " . self::$sUrl . ", " . self::$sDescription . ", " . self::$sCategory . ") VALUES (?, ?, ?, ?)";
				$params = array($pic->getTitle(), $pic->getUrl(), $pic->getDescription(), $categoryId);
				$query = $this->db->prepare($sql);
				$query->execute($params);
			}
			catch (\Exception $e){
				echo $e;
				die("An error occured when trying to add pic to the database!");
			}
		}
	}

	public function checkIfNewCategory(Pic $pic){
		// Hämtar de existerande kategorierna.
		$categories = $this->getCategories();
		$newCategory = true;
		$categoryId = $pic->getCategory();
		
		// Kollar om kategorin som skickades med i $pic redan finns.
		// $newCategory sätts till false om kategorin ej är ny.
		for($i = 0; count($categories) > $i; $i++){
			if($categories[$i]->getId() == $pic->getCategory()){
				$newCategory = false;
			}
		}
		
		// Om en ny kategori ska skapas så läggs den till i databasen och sedan hämtas nya ID:t för kategorin ut.
		if($newCategory == true){
			$this->addCategory($pic->getCategory());
			$categories = $this->getCategories();
			for($i = 0; count($categories) > $i; $i++){
				if($categories[$i]->getName() == $pic->getCategory()){
					$categoryId = $categories[$i]->getId();
				}
			}
		}
		else{
			$categoryId = $pic->getCategory();
		}
		
		return $categoryId;
	}
	
	// Lägger till ny kategori i databasen.
	public function addCategory($name){
		try{
			$sql = "INSERT INTO $this->dbTableCategories (". self::$sCategoryName .") VALUES (?)";
			$params = array($name);
			$query = $this->db->prepare($sql);
			$query->execute($params);
		}
		catch (\Exception $e){
			echo $e;
			die("An error occured when trying to add new category to the database!");
		}
	}
	
	public function updatePic(Pic $pic){
		$categoryId = $this->checkIfNewCategory($pic);
		try{
	    	$sql = "UPDATE $this->dbTable SET " . self::$sTitle . "= '". $pic->getTitle() . "', " . self::$sDescription . "='"
	    	 . $pic->getDescription() ."'," . self::$sCategory ."= '" . $categoryId . "' WHERE " . self::$sId ."= '" . $pic->getId() . "';";
	
			$query = $this->db->prepare($sql);
		
			$query->execute();
			return "<p id='msg'>Saved!</p>";
		}
		catch (\Exception $e) {
			echo $e;
			die("An error occured in the database!");
		}
		
	}
	
	public function deletePicFromFolder($id){
		$pic = $this->getPicInfo($id);
		unlink($this->picDir . $pic->getUrl());
	}
	
	public function deletePic($id){
		$pic = $this->getPicInfo($id);
		try{
			// $this->db = $this->connection();
	    	$sql = "DELETE FROM " . $this->dbTable . " WHERE " . self::$sId . "=" . $id . ";";
			$query = $this->db->prepare($sql);
		
			$query->execute();
		}
		catch (\Exception $e) {
			echo $e;
			die("An error occured in the database!");
		}
	}
	
	public function getAllPics($orderBy){
		$picArr = array();
		$sql = "SELECT * FROM ". $this->dbTable . " ORDER BY ";
		if($orderBy != null){
			$sql .= $orderBy . ",";
		}
		$sql .= self::$sTitle;
		foreach ($this->db->query($sql) as $pic){
			$pic = new Pic($pic[self::$sId], $pic[self::$sTitle], $pic[self::$sUrl], $pic[self::$sDescription], $pic[self::$sCategory]);
			$picArr[] = $pic;
		}

		return $picArr;
	}
	
	public function getCategories(){
		$categoryArr = array();
		$sql = "SELECT * FROM ". $this->dbTableCategories . " ORDER BY " . self::$sCategoryName;
		foreach ($this->db->query($sql) as $category){
			$category = new Category($category[self::$sId], $category[self::$sCategoryName]);
			$categoryArr[] = $category;
		}
		return $categoryArr;
	}
	
	// Returnerar Pic-objekt för vald bild.
	public function getPicInfo($id){
		$sql = $this->db->prepare("SELECT " . self::$sTitle . ", " . self::$sUrl . ", " . self::$sDescription . ", " . self::$sCategory . " FROM ". $this->dbTable . " WHERE " . self::$sId . " = '" . $id . "';");

		if($sql->execute()){
			while($pic = $sql->fetch(PDO::FETCH_ASSOC)){
				$title = $pic[self::$sTitle];
				$url = $pic[self::$sUrl];
				$desc = $pic[self::$sDescription];
				$category = $pic[self::$sCategory];
			}
			$sql = $this->db->prepare("SELECT " . self::$sCategoryName . " FROM " . $this->dbTableCategories . " WHERE id =" . $category);
			try{
				$sql->execute();
				$category = $sql->fetch(PDO::FETCH_ASSOC);
			}
			catch(\Exception $e){
				echo $e;
				die("And error occured in the database!");
			}
				$pic = new Pic($id, $title, $url, $desc, $category[self::$sCategoryName]);

				return $pic;
		}
	}
	
	public function getFileUploadInfo(Pic $pic){
		$filename = $pic->getUrl();
		$fileTmpName = $_FILES["file"]["tmp_name"];
		$extension = pathinfo($filename, PATHINFO_EXTENSION);
	
		return $this->tryUpload($filename, $fileTmpName, $this->picDir);

	}
	
	// Försöker ladda upp bilden i mappen.
	public function tryUpload($filename, $fileTmpName, $picDir){

			try{
				move_uploaded_file($fileTmpName, $picDir . $filename);
				return true;
			}
			catch (\Exception $e){
				echo $e;
				die("An error occured when uploading file to directory!");
			}
 	}
	
	public function checkIfValidExtension($filename){
		$fileExtensions = array("jpeg", "jpg", "png");
 		$extension = pathinfo($filename, PATHINFO_EXTENSION);
 		if(in_array($extension, $fileExtensions)){
 			return true;
 		}
		return false;
	}
	
	public function checkIfFileExists($filename){
		if(file_exists($this->picDir . $filename)){
			return true;
		}
		else return false;
	}
	
	public function generateUniqueUrl($url){
		$ext = "." . pathinfo($url, PATHINFO_EXTENSION);
		$url = str_replace($ext, "1", $url);
		return $url . $ext;
	}
	
	public function getTitleTable(){
		return self::$sTitle;
	}
	
	public function getCategoryTable(){
		return self::$sCategory;
	}
	
	protected function connection() {
		if ($this->dbConnection == NULL)
			$this->dbConnection = new \PDO(\dbSettings::$DB_CONNECTION, \dbSettings::$DB_USERNAME, \dbSettings::$DB_PASSWORD);
		
		$this->dbConnection->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
		
		return $this->dbConnection;
	}
}
