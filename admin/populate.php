<?php
require_once('../includes/config.php');
$query = "UPDATE tblFaces SET OnOff = 1 WHERE FaceID > 0";
$result = mysql_query($query) or die ("Error in query: $query. " . mysql_error());
?>