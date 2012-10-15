<?php
require_once('includes/config.php');
$query = "SELECT * FROM tblEmotions ORDER BY EmotionRank, EmotionName";
$result = mysql_query($query) or die ("Error in query: $query. " . mysql_error());
if (mysql_num_rows($result) > 0)
{
	$x = 0;
	$css = "";
	$sliders = "";
	$setvalues = "";
	while($row = mysql_fetch_object($result))
	{
		$sliders .= "<div id='slider".$row->EmotionID."' class='slider'><span class='slidername'>".$row->EmotionName."</span><input type='hidden' name='value".$row->EmotionID."' value='5'></div>\n";
		$css .= "#slider".$row->EmotionID." .ui-slider-range { background: ".$row->EmotionColour."; }
#slider".$row->EmotionID." .ui-slider-handle { background: ".$row->EmotionColour."; }\n";
		$setvalues .= "$('#slider".$row->EmotionID."').slider( 'value', 5 );\n";
	}
}
?>
<style>
    <?php echo $css; ?>
</style>
<script type="text/javascript">
	
	$(function() {
		$( ".slider" ).slider({
            orientation: "horizontal",
			range: "min",
            max: 10,
            value: 5,
            slide: function( event, ui ) {
            	$(this).children("input").val( ui.value );
		    }
            
		});
	});
</script>
<ul>
<?php
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
	echo "<img id='" . $x . "' src='faces/thumbs/face_" . $round . ".jpg' alt='imagename' width='107' height'127' class='clickable' />\n";
	echo "<div id='form" . $x . "'  class='form'>\n";
	echo "<div class='closeForm'></div>";
	echo "<img id='" . $x . "' src='faces/thumbs/face_" . $round . ".jpg' alt='imagename' height='300' style='float:left;' />\n";
	echo "<div class='slidercont' style='float:left;'><form action='#'>".$sliders."<br><button type='submit' name=submit' value='submit'>submit</button></form></div>";
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