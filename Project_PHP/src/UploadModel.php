<?php

require_once ("src/connectionSettings.php");
require_once("src/Pic.php");

class UploadModel{

	protected $dbConnection;
	protected $dbTable = "pics";
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
		
	public function __construct(){
		$this->db = $this->connection();
	}

	// Lägger till uppladdad blid i databasen.
	public function addPic(Pic $pic) {
	try{
    	$sql = "INSERT INTO $this->dbTable (" . self::$sTitle . ", " . self::$sUrl . ", " . self::$sDescription . ", " . self::$sCategory . ") VALUES (?, ?, ?, ?)";

		$params = array($pic->getTitle(), $pic->getUrl(), $pic->getDescription(), $pic->getCategory());

		$query = $this->db->prepare($sql);
	
		$query->execute($params);

		}
		catch (\Exception $e) {
			echo $e;
			die("An error occured in the database!");
		}
		
	}
	
	public function updatePic(Pic $pic){
		try{
	    	$sql = "UPDATE $this->dbTable SET " . self::$sTitle . "= '". $pic->getTitle() . "', " . self::$sDescription . "='"
	    	 . $pic->getDescription() ."'," . self::$sCategory ."= '" . $pic->getCategory() . "' WHERE " . self::$sId ."= '" . $pic->getId() . "';";
	
			$query = $this->db->prepare($sql);
		
			$query->execute();
			return "<p id='msg'>Sparat!</p>";
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
		try{
			$this->db = $this->connection();
	    	$sql = "DELETE FROM " . $this->dbTable . " WHERE " . self::$sId . "=" . $id . ";";
			echo $sql;
			$query = $this->db->prepare($sql);
		
			$query->execute();
			return "<p id='msg'>Bild borttagen</p>";
		}
		catch (\Exception $e) {
			echo $e;
			die("An error occured in the database!");
		}
	}
	
	public function getAllPics(){
		$i = 0;
		
		$sql = "SELECT * FROM ". $this->dbTable . " ORDER BY " . self::$sTitle;
		foreach ($this->db->query($sql) as $pic){
			$pic = new Pic($pic[self::$sId], $pic[self::$sTitle], $pic[self::$sUrl], $pic[self::$sDescription], $pic[self::$sCategory]);
			$picArr[] = $pic;
		}

		return $picArr;
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

				$pic = new Pic($id, $title, $url, $desc, $category);
		
				$picArr[$this->title] = $title;
				$picArr[$this->url] = $url;
				$picArr[$this->description] = $desc;
				$picArr[$this->category] = $category;
				
				$this->db = null;
				return $pic;
		}
	}
	
	public function getFileUploadInfo(){
		$filename = $_FILES["file"]["name"];
		$fileTmpName = $_FILES["file"]["tmp_name"];
		$extension = pathinfo($filename, PATHINFO_EXTENSION);
		
		return $this->tryUpload($filename, $fileTmpName, $this->picDir);
	}
	
	// Försöker ladda upp bilden i mappen.
	public function tryUpload($filename, $fileTmpName, $picDir){
		
		$fileExtensions = array("jpeg", "jpg", "png");
		$extension = pathinfo($filename, PATHINFO_EXTENSION);
		if(!in_array($extension, $fileExtensions)){
			return "Invalid file";
		}	
		
		else{
			if(file_exists("src/uploadedPics/" . $filename)){
				return "File already exists";
			}
			else{
				move_uploaded_file($fileTmpName, $picDir . $filename);
				echo $picDir . $filename;
				return "'" . $filename . "' uploaded successfully! <br> <img src='". $picDir . $filename . "' class='image' />";
			}
		}
	}
	
	protected function connection() {
		if ($this->dbConnection == NULL)
			$this->dbConnection = new \PDO(\dbSettings::$DB_CONNECTION, \dbSettings::$DB_USERNAME, \dbSettings::$DB_PASSWORD);
		
		$this->dbConnection->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
		
		return $this->dbConnection;
	}
}
