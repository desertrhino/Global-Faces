<ul>
<?php
require_once('includes/config.php');
$query = "SELECT * FROM tblFaces WHERE OnOff = 1 ORDER BY FaceID";
$result = mysql_query($query) or die ("Error in query: $query. " . mysql_error());
if (mysql_num_rows($result) > 0)
{
	while($row = mysql_fetch_object($result))
	{
	}
}
$row = 1;
for ( $x = 1; $x <= $show; $x++) 
{
	$random = rand(1, 41);
	$round = sprintf('%04d', $random);
	echo "<li data-id='" . $x . "' class='" . $round . "'>\n";
	echo "<img id='" . $x . "' src='faces/thumbs/face_" . $round . ".jpg' alt='imagename' width='107' height'127' />\n";
	echo "<div id='form" . $x . "'  class='form'>\n";
	echo "<div class='closeForm'></div>";
	echo "<img id='" . $x . "' src='faces/thumbs/face_" . $round . ".jpg' alt='imagename' height='300' />\n";
	echo "</div>\n";
	echo "</li>";

	if ($row * $accross == $x)
	{
		echo "<div style='clear:both;'></div>";
		$row++;
	}
}
?>
</ul>