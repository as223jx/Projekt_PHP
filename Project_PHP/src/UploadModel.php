<?php

require_once ("src/connectionSettings.php");

class UploadModel{

	protected $dbConnection;
	protected $dbTable = "pics";
	private static $title = "title";
	private static $url = "url";
	private static $description = "description";
	private static $category = "category";
		
	public function __construct(){
	}

	public function addPic(Pic $pic) {
	echo "addPic";
	try{
		$db = $this->connection();

    	$sql = "INSERT INTO $this->dbTable (" . self::$title . ", " . self::$url . ", " . self::$description . ", " . self::$category . ") VALUES (?, ?, ?, ?)";

		$params = array($pic->getTitle(), $pic->getUrl(), $pic->getDescription(), $pic->getCategory());

		$query = $db->prepare($sql);
	
		$query->execute($params);

		}
		catch (\Exception $e) {
			echo $e;
			die("An error occured in the database!");
		}
		
	}
	
	public function getPicInfo($title){
		$db = $this->connection();
		$sql = "SELECT title, description, category FROM pics WHERE title = " . $title . " ORDER BY title";
		foreach ($db->query($sql) as $pic){
			print $pic["title"];
			print $pic["description"];
		}
	}
	
	public function checkFileExtension($filename, $fileTmpName, $picDir){
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
