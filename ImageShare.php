<!DOCTYPE html>
<html>
<head>
	<title>Image Share</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
	<script type="text/javascript" src="uploadFile.js"></script>
	<link rel="stylesheet" type="text/css" href="ImageShare.css">
</head>
<body>
	 <form action="" method="post" id="image_form" enctype="multipart/form-data">
		<textarea id="story" name="story"></textarea><br/>
		
		<label for="caption">Title</label>		
		<input type="text" id="caption" name="title"/>	
		
		<label for="image_input">Select an Image</label>		
		<input type="file" id="image_input" name="image"/>
		
		<input type="submit" value="Submit" />
	</form> 

<?php
include "UserAccountHandler.php";

error_reporting(E_ALL);
ini_set('display_errors', 'On');

$uploaddir = "/nfs/stak/students/r/rademace/public_html/ImageShare/uploads";
$uploadfilename = basename($_FILES['image']['name']);
$uploadfile = $uploaddir . "/" . $uploadfilename;
$tmpName = $_FILES['image']['tmp_name'];

if (0 < $_FILES['image']['error'])
	echo 'Error: ' . $_FILES['image']['error'] . '<br>';

else {
	$retVal = move_uploaded_file($tmpName, $uploadfile);
	if (!$retVal)
		echo "File upload failed.<br/>\n";
}






/* Connect to database */
$mysqli = new mysqli("oniddb.cws.oregonstate.edu",
	"rademace-db", "8xYcLE6mhsNKxGMP", "rademace-db");
if (!$mysqli || $mysqli->connect_errno)
	echo "Connection error: " . $mysqli->connect_errno . " " . $mysqli->connect_error . "<br>";
else
	echo "Connected to onid database<br>";



/* Create database if it does not already exist */
$result = $mysqli->query("SHOW TABLES LIKE 'Stories'");
if ($result === FALSE)
    echo "Query failed <br>";

else if ($result->num_rows < 1) {
	
	if ($mysqli->query("CREATE TABLE Stories(
		id INT PRIMARY KEY AUTO_INCREMENT,
		title VARCHAR(255) UNIQUE,
		story TEXT,
		image VARCHAR(255) NOT NULL
		)") === TRUE) {
			echo "Table 'Stories' created successfully<br>";
		}
		
	else
		echo "failed to create table (" . $mysqli->errno . ") " . $mysqli->error . "<br>"; 
}





/* Add posts to database */
if(isset($_POST['title'])) {
		
	if (strlen($_POST['title']) == 0) {
		echo "<font color=red>Title is a required field</font><br>";
		exit(0);
	}
	
	if (!isset($_FILES['image'])) {
		echo "<font color=red>You must select an image</font><br>";
		exit(0);
	}
	
	else {
		$image = $uploadfilename;
		$title = str_replace ('\'', '\\\'', $_POST['title']);
		$story = str_replace ('\'', '\\\'', $_POST['story']);
		
		if (!($statement = $mysqli->prepare("INSERT INTO Stories(title, story, image) VALUES
			('$title', '$story', '$image')")))
			echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error . "<br>";

		if (!$statement->execute())
			echo "Execute failed: (" . $statement->errno . ") " . $statement->error . "<br>";
		
		$statement->close();
	}
}


/* Display Images */
if (!($statement = $mysqli->prepare("SELECT title, story, image FROM Stories")))
	echo "prepare failed: (" . $mysqli->errno . ") " . $mysqli->error . "<br>";
$statement->bind_param("sss", $title, $story, $image); 
if (!$statement->execute())
	echo "Execute failed: (" . $statement->errno . ") " . $statement->error . "<br>";
$statement->bind_result($resultTitle, $resultStory, $resultImage);


while ($statement->fetch()) {
	echo "<article>";
	echo "<h3>$resultTitle</h3>";
	echo "<img src='uploads/$resultImage' alt='uploads/$resultImage'/>";
	echo "<div>$resultStory</div>";
	echo "</article>\n";
}
$statement->close();



?>
<script type="text/javascript" src="ImageShare.js"></script>
</body>
</html>

 

