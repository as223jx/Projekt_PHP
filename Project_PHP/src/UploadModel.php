<?php

require_once ("src/connectionSettings.php");

class UploadModel{

	protected $dbConnection;
	protected $dbTable = "pics";
	private $db = "";
	private static $title = "title";
	private static $url = "url";
	private static $description = "description";
	private static $category = "category";
	private static $id = "id";
		
	public function __construct(){
		$this->db = $this->connection();
	}

	public function addPic(Pic $pic) {
	echo "addPic";
	try{
		//$db = $this->connection();

    	$sql = "INSERT INTO $this->dbTable (" . self::$title . ", " . self::$url . ", " . self::$description . ", " . self::$category . ") VALUES (?, ?, ?, ?)";

		$params = array($pic->getTitle(), $pic->getUrl(), $pic->getDescription(), $pic->getCategory());

		$query = $this->db->prepare($sql);
	
		$query->execute($params);

		}
		catch (\Exception $e) {
			echo $e;
			die("An error occured in the database!");
		}
		
	}
	
	public function getAllPics(){
		$i = 0;
		
		$sql = "SELECT * FROM pics ORDER BY title";
		foreach ($this->db->query($sql) as $pic){
			$picArr[$i][self::$id] = $pic[self::$id];
			$picArr[$i][self::$title] = $pic[self::$title];
			$picArr[$i][self::$url] = $pic[self::$url];
			$picArr[$i][self::$description] = $pic[self::$description];
			$picArr[$i][self::$category] = $pic[self::$category];
			$i ++;
		}
		return $picArr;
	}
	
	public function getPicInfo($id){
		$sql = $this->db->prepare("SELECT title, url, description, category FROM pics WHERE id = '" . $id . "';");
		
		if($sql->execute()){
			while($pic = $sql->fetch(PDO::FETCH_ASSOC)){
				$title = $pic[self::$title];
				$url = $pic[self::$url];
				$desc = $pic[self::$description];
				$category = $pic[self::$category];
			}
		}
		
		$picArr["title"] = $title;
		$picArr["url"] = $url;
		$picArr["description"] = $desc;
		$picArr["category"] = $category;
		
		$this->db = null;
		return $picArr;
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
