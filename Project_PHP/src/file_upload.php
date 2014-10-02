<?php


if(isset($_FILES["file"])){
	
	$fileExtensions = array("gif", "jpeg", "jpg", "png");
	$filename = $_FILES["file"]["name"];
	$extension = pathinfo($filename, PATHINFO_EXTENSION);
	if(!in_array($extension, $fileExtensions)){
		echo "Invalid file";
		return false;
	}
	else{
		echo $_FILES["file"]["name"];
		if(file_exists("../src/uploadedPics/" . $_FILES["file"]["name"])){
			echo "File already exists";
			$host = $_SERVER["HTTP_HOST"];
			$uri = rtrim(dirname($_SERVER["PHP_SELF"]), "/\\");
			$extra = "../index.php";
			echo ("location: http://" . $host . $uri . "/" . "$extra");
			//return false;
			//header("location: http://" . $host . $uri . "/" . "$extra");
		}
		else{
			$_SESSION["upload_success"] = 1;
			header("location: http://" . $host . $uri . "/" . "$extra");
		}
	}
}