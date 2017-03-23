<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Add Guitar Score</title>
	<style type="text/css">
		.error{
			color:red;
		}
	</style>
</head>
<body>
	<h2>Guitar War</h2>
	<p>This is a place where you can add your guitar score.</p>
	<?php
	require_once('appvars.php');

		if (isset($_POST['submit'])) {
			//Grab the score data from the $_POST variables
			$name = trim($_POST['name']);
			$score = trim($_POST['score']);
			$screenshot = trim($_FILES['screenshot']['name']);
			$file_size = trim($_FILES['screenshot']['size']);
			$file_type = trim($_FILES['screenshot']['type']);

			if (!empty($name) && is_numeric($score) && !empty($screenshot)) {

				if (($file_type == 'image/jpeg' || $file_type == 'image/pjpeg' || $file_type == 'image/png' || $file_type == 'image/gif' ) && ($file_size > 0 && $file_size <= GW_MAXFILESIZE)) {
					
				
				$screenshot = time().$screenshot;
				$target = GW_UPLOADPATH.$screenshot;
				if($_FILES['screenshot']['error'] == 0){
					
				if (move_uploaded_file($_FILES['screenshot']['tmp_name'], $target)) {
				//Connect to database
				$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD,  DB_NAME) or die('Connection Failed');

				$name = mysqli_real_escape_string($dbc,$name);
				$score = mysqli_real_escape_string($dbc,$score);
				$screenshot = mysqli_real_escape_string($dbc,$screenshot);

				//Write data to the database
				$query = "INSERT INTO guitarwars(name,score_date,score,screenshot) VALUES('$name', NOW(), '$score', '$screenshot')";
				$result = mysqli_query($dbc, $query) or die('Query Failed');



				echo "<p>Thanks for submitting your new score!</p>";
				echo "<strong>Name:</strong> ".$name."<br>";
				echo "<strong>Score:</strong> ".$score."<br>";
				echo "<strong>Image:</strong> ".$screenshot."<br>";
				echo '<a href="showscores.php">Back to high scores</a>';

				//Clear the form after submission
				$name = "";
				$score = "";

				//Close the connection
				mysqli_close($dbc);

			}else { echo "<p class='error'>File moving error.</p>";}	
		}
			}else {echo "<p class='error'>The screen shot must be a png, gif or jpeg file no greater than".(GW_MAXFILESIZE/1024)." KB in size.</p>";}
			@unlink($_FILES['screenshot']['tmp_name']);
		}
		else{
					echo "<p class='error'>Pleae enter all of the score data / confirm that the score is a numerical value.</p>";
				}
		}

	 ?>
	<form enctype="multipart/form-data" action="<?php echo $_SERVER['PHP_SELF']; ?>" method = 'post'>
		<input type="hidden" name="MAX_FILE_SIZE" value="128768">
		<label for="name">Your Name</label><br>
		<input type="text" id="name" name="name" value="<?php if(!empty($name)) echo $name; ?>"><br>
		<label for="score">Your Score</label><br>
		<input type="text" id="score" name="score" value="<?php if(!empty($score)) echo $score; ?>"><br>
		<label for="screenshot">Screenshot</label><br>
		<input type="file" id="screenshot" name="screenshot"><br>
		<input type="submit" name="submit">
	</form>
</body>
</html>