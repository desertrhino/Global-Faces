<?php
require_once('config.php');
$query = "SELECT * FROM tblFaces WHERE OnOff = 1 ORDER BY FaceNameLast";
$result = mysql_query($query) or die ("Error in query: $query. " . mysql_error());
if (mysql_num_rows($result) > 0)
{
?>								
	{
    "faces": [
	<?php while($row = mysql_fetch_object($result)) { ?>
        {
            "ID": "<?php echo $row->FaceID; ?>",
            "Name": "<?php echo $row->FaceName; ?>",
            "NameLast": "<?php echo $row->FaceNameLast; ?>",
            "LinkName": "<?php echo $row->FaceLinkName; ?>",
            "Description": "<?php echo $row->FaceDesc; ?>"
        }
	<?php } ?>
	}
<?php } ?>