<?php
require_once('config.php');
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
		$x++;
		$css .= "#".$row->EmotionID." .ui-slider-range { background: ".$row->EmotionColour."; }\n
				#".$row->EmotionID." .ui-slider-handle { border-color: ".$row->EmotionColour."; }\n";
		$sliders .= "<div id='".$row->EmotionID."' class='slider'></div>\n";
		$setvalues .= "$('#".$row->EmotionID."').slider( 'value', 5 );\n";	
	}
}
?>
<script>
	$(function() {
		$( ".slider" ).slider({
			orientation: "horizontal",
			range: "min",
			max: 255,
			value: 127,
			slide: refreshSwatch,
			change: refreshSwatch
		});
        <?php echo $setvalues; ?>
    });
</script>
<style>
    .slider {
        float: left;
        clear: left;
        width: 300px;
        margin: 15px;
    }
    <?php echo $css; ?>
</style>
<?php echo $sliders; ?>