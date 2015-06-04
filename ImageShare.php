<!DOCTYPE html>

<?php

if (isset($_POST['deleteID'])) {
	if ($_POST['author'] != $_SESSION['name']) {
		var_dump($_POST['author']);
		var_dump($_SESSION['name']);
		echo "<div class=red>You are not authorized to delete that post</div>";
	}
	
	else {
		if (!($stmt = $mysqli->prepare("DELETE FROM Stories
			WHERE id = $_POST[deleteID]")))
			echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error . "<br>";
			
		if (!$stmt->execute())
			echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error . "<br>";
	}
	
}


if (!$loggedIn) {
	echo '<div class=blue>You are not logged in</div>
		Click <a href="http://web.engr.oregonstate.edu/~rademace/ImageShare/ImageShareLogin.html">here</a>
		to login<br>';
	exit(0);
}

?>
<html>
<head>
	<title>Image Share</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
	<script type="text/javascript" src="uploadFile.js"></script>
	<link rel="stylesheet" type="text/css" href="ImageShare.css">
</head>
<body>
	<h1>ImageShare</h1>
	<form action="" method="post" id="image_form" enctype="multipart/form-data">
		<textarea id="story" name="story"></textarea><br/>
		
		<label for="caption">Title</label>		
		<input type="text" id="caption" name="title"/>	
		
		<label for="image_input">Select an Image</label>		
		<input type="file" id="image_input" name="image"/>
		
		<input type="submit" value="Submit" />
	</form> 

<?php
// error_reporting(E_ALL);
// ini_set('display_errors', 'On');

if (isset($_FILES['image']['name']))  {
	$uploaddir = "/nfs/stak/students/r/rademace/public_html/ImageShare/uploads";
	$uploadfilename = basename($_FILES['image']['name']);
	$uploadfilename = str_replace('\'', '', $uploadfilename); //strip apostrophes
	$uploadfile = $uploaddir . "/" . $uploadfilename;
	$tmpName = $_FILES['image']['tmp_name'];

	if (0 < $_FILES['image']['error'] AND $_FILES['image']['error'] != 4)
		echo 'Error: ' . $_FILES['image']['error'] . '<br>';

	else {
		$retVal = move_uploaded_file($tmpName, $uploadfile);
		if (!$retVal)
			echo "<div class=orange>File upload failed</div><br>";
	}
}



/* Connect to database */
$mysqli = new mysqli("oniddb.cws.oregonstate.edu",
	"rademace-db", "8xYcLE6mhsNKxGMP", "rademace-db");
if (!$mysqli || $mysqli->connect_errno)
	echo "Connection error: " . $mysqli->connect_errno . " " . $mysqli->connect_error . "<br>";


/* Create table if it does not already exist */
$result = $mysqli->query("SHOW TABLES LIKE 'Stories'");
if ($result === FALSE)
    echo "Query failed <br>";

else if ($result->num_rows < 1) {
	
	if ($mysqli->query("CREATE TABLE Stories(
		id INT PRIMARY KEY AUTO_INCREMENT,
		title VARCHAR(255) UNIQUE,
		story TEXT,
		image VARCHAR(255) NOT NULL,
		author VARCHAR(255)
		)") === TRUE) {
			echo "Table 'Stories' created successfully<br>";
		}
		
	else
		echo "failed to create table (" . $mysqli->errno . ") " . $mysqli->error . "<br>"; 
}





/* Add posts to database */
if(isset($_POST['title']) OR isset($_FILES['image']) OR isset($_POST['story'])) {
		
	if (strlen($_POST['title']) == 0) {
		echo "<div class=red>Title is a required field</div><br>";
		goto DISPLAY;
	}
	
	if ($_FILES['image']['size'] < 10) {
		echo "<div class=red>You must select an image</div><br>";
		goto DISPLAY;
	}
	
	else {
		$image = $uploadfilename;
		$title = str_replace ('\'', '\\\'', $_POST['title']);
		$story = str_replace ('\'', '\\\'', $_POST['story']);
		$author = $_SESSION['name'];
		
		if (!($statement = $mysqli->prepare("INSERT INTO Stories(title, story, image, author) VALUES
			('$title', '$story', '$image', '$author')")))
			echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error . "<br>";

		if (!$statement->execute()) {
			if ($statement->errno == 1062)
				echo "<div class=red>This title is already being used</div><br>";
			
			else
				echo "Execute failed: (" . $statement->errno . ") " . $statement->error . "<br>";
			
		}
		
		$statement->close();
	}
}

DISPLAY:
/* Display Images */
if (!($statement = $mysqli->prepare("SELECT id, title, story, image, author FROM Stories")))
	echo "prepare failed: (" . $mysqli->errno . ") " . $mysqli->error . "<br>";
$statement->bind_param("isss", $id, $title, $story, $image, $author); 
if (!$statement->execute())
	echo "Execute failed: (" . $statement->errno . ") " . $statement->error . "<br>";
$statement->bind_result($resultID, $resultTitle, $resultStory, $resultImage, $resultAuthor);


while ($statement->fetch()) {
	echo "<article>";
	echo
		"<form method=POST class=deleteForm>
			<input type=text name=author value=$resultAuthor style='display: none;'></input>
			<button type=submit name=deleteID value=$resultID class=deleteButton>Delete</button>
		</form>";
	echo "<h3>$resultTitle</h3>";
	echo "<h4>by $resultAuthor</h4>";
	echo "<img src='uploads/$resultImage' alt='uploads/$resultImage'/>";
	echo "<div>$resultStory</div>";
	echo "</article>\n";
}
$statement->close();



?>
<script type="text/javascript" src="ImageShare.js"></script>
</body>
</html>

 

