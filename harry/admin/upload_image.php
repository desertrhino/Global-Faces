<?php
require_once('../includes/config.php'); 
ini_set("memory_limit", "200000000");?>
<?php
if ((isset($_POST["submitted_form"])) && ($_POST["submitted_form"] == "image_upload_form"))
{
	if (($_FILES["image_upload_box"]["type"] == "image/jpeg" || $_FILES["image_upload_box"]["type"] == "image/pjpeg" && ($_FILES["image_upload_box"]["size"] < 4000000))
	{
		if (isset($_GET[Type]))
		{
			if ($_GET[Type] == "AlbumArt")
			{
				$max_upload_width = 200;
				$max_upload_height = 200;
				$Folder = "../albumart/";
			} 
			else if ($_GET[Type] == "")
			{
				$max_upload_width = ;
				$max_upload_height = ;
			}
			else
			{
				$max_upload_width = 480;
				$max_upload_height = 480;
			}
		  
		// if user chosed properly then scale down the image according to user preferances
		if(isset($_REQUEST['max_width_box']) and $_REQUEST['max_width_box']!='' and $_REQUEST['max_width_box']<=$max_upload_width){
			$max_upload_width = $_REQUEST['max_width_box'];
		}    
		if(isset($_REQUEST['max_height_box']) and $_REQUEST['max_height_box']!='' and $_REQUEST['max_height_box']<=$max_upload_height){
			$max_upload_height = $_REQUEST['max_height_box'];
		}	

		
		// if uploaded image was JPG/JPEG
		if($_FILES["image_upload_box"]["type"] == "image/jpeg" || $_FILES["image_upload_box"]["type"] == "image/pjpeg"){	
			$image_source = imagecreatefromjpeg($_FILES["image_upload_box"]["tmp_name"]);
		}		
		$random = rand(0, 99);
		
		$remote_file = "images/".$random . "_" . $_FILES["image_upload_box"]["name"];
		imagejpeg($image_source,$remote_file,60);
		chmod($remote_file,0644);

		// get width and height of original image
		list($image_width, $image_height) = getimagesize($remote_file);
	
		if($image_width>$max_upload_width || $image_height >$max_upload_height)
		{
			$proportions = $image_width/$image_height;
			
			if($image_width>$image_height)
			{
				$new_width = $max_upload_width;
				$new_height = round($max_upload_width/$proportions);
			}		
			else
			{
				$new_height = $max_upload_height;
				$new_width = round($max_upload_height*$proportions);
			}		
			
			$new_image = imagecreatetruecolor($new_width, $new_height);
			$image_source = imagecreatefromjpeg($remote_file);
			
			imagecopyresampled($new_image, $image_source, 0, 0, 0, 0, $new_width, $new_height, $image_width, $image_height);
			imagejpeg($new_image, $remote_file, 60);
			
			imagedestroy($new_image);
		}
		
		imagedestroy($image_source);
		
		$query = "INSERT INTO tblPhotos (PhotoHttp, PhotoType, PhotoApproved) VALUES ('$remote_file', 1, 0)";
		$result = mysql_query($query) or die ("Error in query: $query. " . mysql_error());
		
		header("Location: submit.php?upload_message=image uploaded&upload_message_type=success&show_image=".$_FILES["image_upload_box"]["name"]);
		exit;
	}
	else
	{
		header("Location: submit.php?upload_message=make sure the file is jpg, gif or png and that is smaller than 4MB&upload_message_type=error");
		exit;
	}
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Image Upload with resize</title>
<style type="text/css">
<!--
body,td,th {
	font-family: Arial, Helvetica, sans-serif;
	color: #333333;
	font-size: 12px;
}

.upload_message_success {
	padding:4px;
	background-color:#009900;
	border:1px solid #006600;
	color:#FFFFFF;
	margin-top:10px;
	margin-bottom:10px;
}

.upload_message_error {
	padding:4px;
	background-color:#CE0000;
	border:1px solid #990000;
	color:#FFFFFF;
	margin-top:10px;
	margin-bottom:10px;
}

-->
</style></head>

<body>

<h1 style="margin-bottom: 0px">Submit an image</h1>


        <?php if(isset($_REQUEST['upload_message'])){?>
            <div class="upload_message_<?php echo $_REQUEST['upload_message_type'];?>">
            <?php echo htmlentities($_REQUEST['upload_message']);?>
            </div>
		<?php }?>


<form action="submit.php" method="post" enctype="multipart/form-data" name="image_upload_form" id="image_upload_form" style="margin-bottom:0px;">
<label>Image file, maximum 4MB. it can be jpg, gif,  png:</label><br />
          <input name="image_upload_box" type="file" id="image_upload_box" size="40" />
          <input type="submit" name="submit" value="Upload image" />     
     
     <br />
	<br />

      <br />
      <p style="padding:5px; border:1px solid #EBEBEB; background-color:#FAFAFA;">
<input name="submitted_form" type="hidden" id="submitted_form" value="image_upload_form" />
          </form>

<?php if(isset($_REQUEST['show_image']) and $_REQUEST['show_image']!=''){?>
<p>
	<img src="image_files/<?php echo $_REQUEST['show_image'];?>" />
</p>
<?php }?>




</body>
</html>


