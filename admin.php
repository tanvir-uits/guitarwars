<?php 
require_once('auth.php');

 ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Show Scores</title>
	<style type="text/css">
		.padding td{
			padding:1em;
		}
		.top{
			text-align: center;
			font-weight: 900;
			font-size: 1.5em;
			padding: 2em;
		}
	</style>
</head>
<body>
	<h2>Guitar Wars</h2>
	<p>The scores of the guitar war is given below:</p>
	<table border="1">
	<tr><th>Name</th><th>Date</th><th>Score</th><th>Screenshot</th><th>Edit</th><th>Approve</th></tr>
	<?php
	require_once('appvars.php'); 
		$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD,  DB_NAME) or die('connection failed');
		$query = "SELECT * FROM guitarwars ORDER BY score DESC, score_date ASC";
		$result = mysqli_query($dbc, $query) or die('query failed');
		$row = mysqli_fetch_array($result);
		echo "<tr><td colspan='6' class='top'>Top Score: ".$row['score']."</td></tr>";
			echo "<tr class='padding'><td>".$row['name']."</td><td>".$row['score_date']."</td><td>".$row['score']."</td>";
			if (is_file(GW_UPLOADPATH.$row['screenshot']) && filesize(GW_UPLOADPATH.$row['screenshot']) > 0) {
				echo "<td><img width='100' src='".GW_UPLOADPATH.$row['screenshot']."' alt='Score Image'></td>";
			}
			echo '<td><a href="removescore.php?id=' . $row['id'] . '&amp;score_date=' . $row['score_date'] .
'&amp;name=' . $row['name'] . '&amp;score=' . $row['score'] . '&amp;screenshot=' .
$row['screenshot'] . '">Remove</a></td>';
		if ($row['approved'] == 0) {
			echo '<td><a href="approve.php?id=' . $row['id'] . '&amp;score_date=' . $row['score_date'] .
'&amp;name=' . $row['name'] . '&amp;score=' . $row['score'] . '&amp;screenshot=' .
	$row['screenshot'] . '">Approve</a></td>';
		}
		echo '</tr>';
		while ($row = mysqli_fetch_array($result)) {
			echo "<tr class='padding'><td>".$row['name']."</td><td>".$row['score_date']."</td><td>".$row['score']."</td>";
			if (is_file(GW_UPLOADPATH.$row['screenshot']) && filesize(GW_UPLOADPATH.$row['screenshot']) > 0) {
				echo "<td><img width='100' src='".GW_UPLOADPATH.$row['screenshot']."' alt='Score Image'></td>";
			}
			echo '<td><a href="removescore.php?id=' . $row['id'] . '&amp;score_date=' . $row['score_date'] .
'&amp;name=' . $row['name'] . '&amp;score=' . $row['score'] . '&amp;screenshot=' .
$row['screenshot'] . '">Remove</a></td>';
	if ($row['approved'] == 0) {
			echo '<td><a href="approve.php?id=' . $row['id'] . '&amp;score_date=' . $row['score_date'] .
'&amp;name=' . $row['name'] . '&amp;score=' . $row['score'] . '&amp;screenshot=' .
	$row['screenshot'] . '">Approve</a></td>';
		}
		echo '</tr>';
		 } 
	?>
	</table>
	<p>You can add a new score <a href="addscore.php">here</a></p>
</body>
</html>