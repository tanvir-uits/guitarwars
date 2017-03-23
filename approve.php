<?php 
require_once('auth.php');

 ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Remove Score</title>
</head>
<body>
	<h2>Guitar Wars</h2>
	<?php  
		require_once('appvars.php');
		if (isset($_GET['id']) && isset($_GET['score']) && isset($_GET['score_date']) && isset($_GET['name'])) {
			//Grab the score data
			$id = $_GET['id'];
			$score = $_GET['score'];
			$score_date = $_GET['score_date'];
			$name = $_GET['name'];
			$screenshot = $_GET['screenshot'];
		}
		else if (isset($_POST['id']) && isset($_POST['name']) && isset($_POST['score'])) {
			$id = $_POST['id'];
			$name = $_POST['name'];
			$score = $_POST['score'];
		}
		else{
			echo "<p class='error'>Sorry, no high score was specified for approval.</p>";
		}

		if (isset($_POST['submit'])) {
			if ($_POST['confirm'] == 'Yes') {
				//Delete the screen shot image file from the server
				@unlink(GW_UPLOADPATH.$screenshot);

				//connect to the database
				$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
				$query = "UPDATE guitarwars SET approved = 1 WHERE id = '$id'";

				mysqli_query($dbc, $query);
				mysqli_close($dbc);

				//Confirm success with user
				echo " The high score of $score for $name was approved.";				
			}
			else{
				echo "The high score wasn't approved";
			}
		}
		else if (isset( $_GET['id'])) {
			echo '<p>Are you sure you want to approve the following high score?</p>'; 
echo '<p><strong>Name: </strong>' . $name . '<br /><strong>Date: </strong>' . $score_date . 
'<br /><strong>Score: </strong>' . $score . '</p>'; 
echo '<form method="post" action="approve.php">'; 
echo '<input type="radio" name="confirm" value="Yes" /> Yes '; 
echo '<input type="radio" name="confirm" value="No" checked="checked" /> No <br />'; 
echo '<input type="submit" value="Submit" name="submit" />'; 
echo '<input type="hidden" name="id" value="' . $id. '" />'; 
echo '<input type="hidden" name="name" value="' . $name . '" />'; 
echo '<input type="hidden" name="score" value="' . $score . '" />'; 
echo '</form>';
		}
		echo '<p><a href="admin.php">&lt;&lt; Back to admin page</a></p>'
	?>
</body>
</html>