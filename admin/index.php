<? 
/* Include Files *********************/
session_start(); 
require_once('../includes/config.php');
include("login.php");
if ($_GET[Type] == "Faces") { include("upload_new.php"); }
<?php
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
		$css .= "#".$row->EmotionID." .ui-slider-range { background: ".$row->EmotionColour."; }
#".$row->EmotionID." .ui-slider-handle { border-color: ".$row->EmotionColour."; }\n";
		$setvalues .= "$('#".$row->EmotionID."').slider( 'value', 5 );\n";	
	}
}
/*************************************/
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title><? if (isset($site)) { echo $site; } ?>Administration</title>

<link href="css/admin.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>

<link href="css/SpryCollapsiblePanel.css" rel="stylesheet" type="text/css" />

<!-- ckeditor -->
<script type="text/javascript" src="ckeditor/ckeditor.js"></script>
<script src="ckeditor/_samples/sample.js" type="text/javascript"></script>
<link href="ckeditor/_samples/sample.css" rel="stylesheet" type="text/css" />

<!-- bbeditor-->
<script type="text/javascript" src="bbeditor/ed.js"></script>

<!-- Image Upload -->
<script type="text/javascript" src="scripts/jquery-pack.js"></script>
<script type="text/javascript" src="scripts/jquery.imgareaselect.min.js"></script>

<!-- colour Picker -->
<script type="text/javascript" src="scripts/farbtastic.js"></script>
<link rel="stylesheet" href="css/farbtastic.css" type="text/css" />
 
<script type="text/javascript">
<!--
function checkTextArea(textArea, max){
 var numChars, chopped, message;
 if (!checkLength(textArea.value, 0, max)) {
  numChars = textArea.value.length;
  chopped = textArea.value.substr(0, max);
  message = 'You typed ' + numChars + ' characters.\n';
  message += 'The limit is ' + max + '.';
  message += 'Your entry will be shortened to:\n\n' + chopped;
  alert(message);
  textArea.value = chopped;
 }
}
//-->
</script>
<script type="text/javascript">
$(document).ready(function(){

	$(".CollapsiblePanelTab").click(function(){
		$(".CollapsiblePanel").slideToggle("fast");
		$(this).toggleClass("active"); return false;
	});
	
	$('#colourpicker').farbtastic('#Colour');
	
	$( ".slider" ).slider({
		orientation: "horizontal",
		range: "min",
		max: 255,
		value: 127,
		slide: refreshSwatch,
		change: refreshSwatch
	});
});
</script>

<style>
    .slider {
        float: left;
        clear: left;
        width: 260px;
        margin: 15px;
    }
    <?php echo $css; ?>
</style>
</head>

<?php 
if($logged_in)
{

	if (isset($_POST[day]))
	{
		if(strlen($_POST[day]) < 2)
		{
			$day = "0" . $_POST[day];
		}
		else
		{
			$day = $_POST[day];
		}
	}
	if (isset($_POST[month]))
	{
		if(strlen($_POST[month]) < 2)
		{
			$month = "0" . $_POST[month];
		}
		else
		{
			$month = $_POST[month];
		}
	}
	if (isset($_POST[year]))
	{
		if(strlen($_POST[year]) < 4)
		{
			$year = "20" . $_POST[year];
		}
		else
		{
			$year = $_POST[year];
		}
	}
	$PostDate = mktime(0, 0, 0, $month, $day, $year);
	?>
	
	<body>
	
	<div class="container">
	
		<div class="header">
			
			<div id="admin">
				<p><a href='logout.php' target='_parent' class="Button"> LOGOUT </a></p>
			</div> <!-- admin -->
		</div> <!-- header -->
		
		<div class="menu">
			<ul>
				<li><a href="index.php?Type=Config" <?php if (!isset($_GET[Type]) || $_GET[Type] == "Config") { echo "class='current'"; }?> >Config</a></li>
				<li><a href="index.php?Type=Faces" <?php if ($_GET[Type] == 'Faces') { echo "class='current'"; }?> >Faces</a></li>
				<li><a href="index.php?Type=Emotions" <?php if ($_GET[Type] == 'Emotions') { echo "class='current'"; }?> >Emotions</a></li>
			</ul>
		</div> <!-- menu -->
		
		<div class="mainContent">
			
			<?php
			
			###########################################################################################
			########   CONFIG   #######################################################################
			###########################################################################################
				
			if (!isset($_GET[Type]) || $_GET[Type] == "Config")
			{
				
				if ($_GET[Submit] == "Config")
				{
					$query = "UPDATE tblConfig SET ConfigHomeTitle = '$_POST[HomeTitle]', ConfigFooterText = '$_POST[FooterText]' WHERE ConfigID = '1'";
					$result = mysql_query($query) or die ("Error in query: $query. " . mysql_error());
					echo "<h5>Details has been updated.</h5>";
				}
				
				$query = "SELECT * FROM tblConfig WHERE ConfigID = '1'";
				$result = mysql_query($query) or die ("Error in query: $query. " . mysql_error());
				if (mysql_num_rows($result)>0);
				{
					$Info = mysql_fetch_array($result);
					$HomeTitle = $Info[ConfigHomeTitle];
					$FooterText = $Info[ConfigFooterText];
				}
				?>
				<div class="PanelTab">
					<h3> Configuration</h3>
				</div>
				<div class="CollapsiblePanelContent">
					<form action="index.php?Type=<?php echo $_GET[Type]; ?>&Action=Edit&Submit=Config" method="POST" enctype="multipart/form-data" name="Details" target="_self" id="Details">
						<table width="100%" border="0" cellspacing="0" cellpadding="0">
							
							<tr>
								<td width="150" align="right" valign="top"><h2>Home Title: </h2></td>
								<td> <input name="HomeTitle" type="text" maxlength="100" style="width:400px;" <?php echo "value='" . $HomeTitle ."'"; ?>>
								</td>
							</tr>
							<tr>
								<td width="150" align="right" valign="top"><h2>Footer Text: </h2></td>
								<td> <textarea name="FooterText" type="text" maxlength="100" style="width:400px;"> <?php echo $FooterText; ?></textarea>
								</td>
							</tr>
							<tr>
								<td  colspan="2">
									<p align="center"><input type="image" src="images/submit.png" alt="submit" /></p></td>
							</tr>
						</table>
					</form>
				</div>
				<?php
			}
			
			###########################################################################################
			########    FACES    ######################################################################
			###########################################################################################
			
			else if ($_GET[Type] == "Faces")
			{
				if (isset($_POST[EditFaceSubmit]))
				{
					$query = "UPDATE tblFaces SET FaceName = '$_POST[Name]', FaceName = '$_POST[Name]', FaceNameLast = '$_POST[NameLast]', FaceDesc = '$_POST[Desc]' WHERE FaceID = '$_POST[ID]'";
					$result = mysql_query($query) or die ("Error in query: $query. " . mysql_error());
					echo "<h5>Face's information has been updated.</h5>";
					$GalleryFace = 1;
				}
				if (isset($_POST[EditFace]))
				{
					$Edit = 1;
					$query = "SELECT * FROM tblFaces WHERE FaceID = '$_POST[ID]'";
					$result = mysql_query($query) or die ("Error in query: $query. " . mysql_error());
					if (mysql_num_rows($result)>0);
					{
						$Info = mysql_fetch_array($result);
						$FaceID = $Info[FaceID];
						$Name = $Info[FaceName];
						$LinkName = $Info[FaceLinkName];
						$NameLast = $Info[FaceNameLast];
						$Desc = $Info[FaceDesc];
					}
				}
				else if (isset($_POST[OnOff]))
				{
					if ($_POST[On] == "1")
					{
						$query = "UPDATE tblFaces SET OnOff = 0 WHERE FaceID = '$_POST[ID]'";
						$result = mysql_query($query) or die ("Error in query: $query. " . mysql_error());
						echo "<h5>Face has been Turned Off.</h5>";
					}
					else if ($_POST[On] == "0")
					{
						$query = "UPDATE tblFaces SET OnOff = 1 WHERE FaceID = '$_POST[ID]'";
						$result = mysql_query($query) or die ("Error in query: $query. " . mysql_error());
						echo "<h5>Face has been Turned On.</h5>";
					}
				}
				else if (isset($_POST[DelFace]))
				{
					
				}
									
				if ($Edit == 1)
				{
					
					echo "<h5>&nbsp;</h5><h3> Edit Face</h3>";
					echo "<img src='/faces/thumbs/" . $LinkName . ".jpg' /><br />";
					?>
						<table width="100%" border="0" cellspacing="0" cellpadding="0">
	
						<form action="index.php?Type=<?php echo $_GET[Type]; ?>" method="POST" enctype="multipart/form-data" name="edit Face" target="_self" id="edit Face">
							</tr>
							<tr>
								<td width="150" align="right" valign="top"><h2>Name: </h2></td>
								<td>
								<input type="hidden" name="ID" value="<?php echo $FaceID;?>" />
								<input name="Name" type="text" maxlength="50" value="<?php echo $Name; ?>"> 
								<input name="NameLast" type="text" maxlength="50" value="<?php echo $NameLast; ?>">
								<?php echo $LinkName; ?>
								</td>
							</tr>	
							<tr>
								<td width="150" align="right" valign="top"><h2>Face Description: </h2></td>
								<td> <textarea name="Desc" cols="25"><?php if ($Edit == 1) { echo $Desc; } ?></textarea>
								</td>
							</tr>
							<tr>
								<td width="150" align="right" valign="top">&nbsp;</td>
								<td>
									
									<p align="right">								
									<input type="hidden" name="EditFaceSubmit" value="EditFaceSubmit" />
									<button name="Submit" type="submit">submit</button></p>
								</td>
							</tr>
						</form>
						</table>
				
					<?php
				}
				else
				{
				?>
					<h3>Add New Face</h3>
					<?php
					if (strlen($error) > 0)
					{
						echo "<ul><li><strong>Error!</strong></li><li>".$error."</li></ul>";
					}
					if (strlen($large_photo_exists) > 0)
					{
						if (strlen($large_photo_exists) > 0 && strlen($thumb_photo_exists) > 0)
						{
						?>
							<h5>Face has been added.</h5><br>
							<h2>Upload Face</h2>
							<form name="Face" enctype="multipart/form-data" action="index.php?Type=<?php echo $_GET[Type]; ?>&Action=Add" method="post"  target="_self" id="add Face">
								<input type="file" name="image" size="30" /> <input type="submit" name="upload" value="Upload" />
							</form>
							<br />&nbsp;
							<?php
							$_SESSION['random_key']= "";
							$_SESSION['user_file_ext']= "";
						}
						else
						{
							$current_large_image_width = getWidth($large_image_location);
							$current_large_image_height = getHeight($large_image_location);
							?>
							<script type="text/javascript">
								function preview(img, selection) { 
									var scaleX = <?php echo $thumb_width;?> / selection.width; 
									var scaleY = <?php echo $thumb_height;?> / selection.height; 
									
									$('#thumbnail + div > img').css({ 
										width: Math.round(scaleX * <?php echo $current_large_image_width;?>) + 'px', 
										height: Math.round(scaleY * <?php echo $current_large_image_height;?>) + 'px',
										marginLeft: '-' + Math.round(scaleX * selection.x1) + 'px', 
										marginTop: '-' + Math.round(scaleY * selection.y1) + 'px' 
									});
									$('#x1').val(selection.x1);
									$('#y1').val(selection.y1);
									$('#x2').val(selection.x2);
									$('#y2').val(selection.y2);
									$('#w').val(selection.width);
									$('#h').val(selection.height);
								} 
								
								$(document).ready(function () { 
									$('#save_thumb').click(function() {
										var x1 = $('#x1').val();
										var y1 = $('#y1').val();
										var x2 = $('#x2').val();
										var y2 = $('#y2').val();
										var w = $('#w').val();
										var h = $('#h').val();
										if(x1=="" || y1=="" || x2=="" || y2=="" || w=="" || h==""){
											alert("You must make a selection first");
											return false;
										}else{
											return true;
										}
									});
								}); 
								
								$(window).load(function () { 
									$('#thumbnail').imgAreaSelect({ aspectRatio: '1:<?php echo $thumb_height/$thumb_width;?>', onSelectChange: preview }); 
								});
							
							</script>
							<h2>Create Image</h2>
							<div align="center">
								<img src="<?php echo $upload_path.$large_image_name.$_SESSION['user_file_ext'];?>" style="float: left; margin-right: 10px;" id="thumbnail" alt="Create Thumbnail" />
								<div style="border:1px #e5e5e5 solid; float:left; position:relative; overflow:hidden; width:<?php echo $thumb_width;?>px; height:<?php echo $thumb_height;?>px;">
									<img src="<?php echo $upload_path.$large_image_name.$_SESSION['user_file_ext'];?>" style="position: relative;" alt="Thumbnail Preview" />
								</div>
								<br style="clear:both;"/>
								<form name="thumbnail" action="<?php echo $_SERVER["PHP_SELF"];?>?Type=<?php echo $_GET[Type]; ?>" method="post">
									<input type="hidden" name="x1" value="" id="x1" />
									<input type="hidden" name="y1" value="" id="y1" />
									<input type="hidden" name="x2" value="" id="x2" />
									<input type="hidden" name="y2" value="" id="y2" />
									<input type="hidden" name="w" value="" id="w" />
									<input type="hidden" name="h" value="" id="h" />
									
									<table width="100%" border="0" cellspacing="0" cellpadding="0">										
										<tr>
											<td width="150" align="right" valign="top"><h2>Name: </h2></td>
											<td> <input name="Name" type="text" maxlength="50"> 
											<input name="NameLast" type="text" maxlength="50">
											</td>
										</tr>	
										<tr>
											<td width="150" align="right" valign="top"><h2>Face Description: </h2></td>
											<td> <textarea name="Desc" cols="25"></textarea>
											</td>
										</tr>
										<tr>
											<td width="150" align="right" valign="top">&nbsp;</td>
											<td>
												<p align="right">
												<button name="upload_thumbnail" type="submit">Save Thumbnail</button></p>
											</td>
										</tr>
									</table>
						
								</form>
							</div>
							<hr />
						<?php
						}
					}
					else 
					{
					?>
						<h2>Add Face</h2>
						<form name="Face" enctype="multipart/form-data" action="index.php?Type=<?php echo $_GET[Type]; ?>&Action=Add" method="post"  target="_self" id="add Face">
							<input type="file" name="image" size="30" /> <input type="submit" name="upload" value="Upload" />
						</form>
						<br />&nbsp;
					<?php	
					}
					?>
					<div style='height:10px;'></div>
					<h3 style="text-align:center;">Faces:</h3>
					<?php
					$query = "SELECT * FROM tblFaces ORDER BY FaceID";
					$result = mysql_query($query) or die ("Error in query: $query. " . mysql_error());
					if (mysql_num_rows($result) > 0)
					{
					?>								
						<table width='100%' border='0' cellpadding='0' cellspacing='0'>
						<?php
						$x = 0;
						while($row = mysql_fetch_object($result))
						{
							$x++;
						?>
							<tr <?php
								if ($x == 1)
								{
									echo "class='fill'"; 
								}
								else 
								{
									$x = 0;
								}
								?>>
								<td width="100%"><h2><?php echo $row->FaceName . " " . $row->FaceNameLast; ?></h2></td>
								<td width="1%">
									<form action="index.php?Type=<?php echo $_GET[Type]; ?>" method="POST" enctype="multipart/form-data" target="_self">
										<input type="hidden" name="ID" value="<?php echo $row->FaceID; ?>" />
										<input type="hidden" name="Name" value="<?php echo $row->FaceName . " " . $row->FaceNameLast; ?>" />
										<input type="hidden" name="On" value="<?php echo $row->OnOff; ?>" />
										<input type="hidden" name="OnOff" value="OnOff" />
										<?php
										if ($row->OnOff > 0)
										{
										?>
											<input type="image" src="images/On.png" alt="Turn Off" />
										<?php
										}
										else
										{
										?>
											<input type="image" src="images/Off.png" alt="Turn On" name="OnOff" value="OnOff" />
										<?php
										}
										?>
									</form>
								</td>
								<td width="1%">
									<form action="index.php?Type=<?php echo $_GET[Type]; ?>" method="POST" enctype="multipart/form-data" target="_self">
										<input type="hidden" name="ID" value="<?php echo $row->FaceD; ?>" />
										<input type="hidden" name="Name" value="<?php echo $row->FaceName . " " . $row->FaceNameLast; ?>" />
										<input type="hidden" name="DelFace" value="DelFace" />
										<input type="image" src="images/Delete.png" alt="delete" onclick="return confirm('Are you sure you want to delete this Face?')" />
									</form>
								</td>
								<td width="1%">
									<form action="index.php?Type=<?php echo $_GET[Type]; ?>" method="POST" enctype="multipart/form-data" target="_self">
										<input type="hidden" name="ID" value="<?php echo $row->FaceID; ?>" />
										<input type="hidden" name="Name" value="<?php echo $row->FaceName . " " . $row->FaceNameLast; ?>" />
										<button name="EditFace" type="submit">Edit</button>
									</form>
								</td>
								<?php
							}
							?>
							</table>
							<div style="clear:both"></div>
						</div><br />
					<?php
					}
				}
			}
			
			#######################################################################################
			###########    Emotion     ############################################################
			#######################################################################################
			
			else if ($_GET[Type] == "Emotions")
			{
				if (isset($_POST[add]))
				{
					$query = "INSERT INTO tblEmotions (EmotionName, EmotionDesc, EmotionColour) VALUES ('$_POST[Name]', '$_POST[Desc]', '$_POST[Colour]')";
					$result = mysql_query($query) or die ("Error in query: $query. " . mysql_error());
					echo "<h5>" . $_POST[Name] . " have been added.</h5>";
				}
				if (isset($_POST[editsubmit]))
				{
					$query = "UPDATE tblEmotions SET EmotionName = '$_POST[Name]', EmotionDesc = '$_POST[Desc]', EmotionColour = '$_POST[Colour]' WHERE EmotionID = '$_POST[ID]'";
					$result = mysql_query($query) or die ("Error in query: $query. " . mysql_error());
					echo "<h5>" . $_POST[Name] . " have been updated.</h5>";
				}
				if (isset($_POST[edit]))
				{
					$Edit = 1;
				
					$query = "SELECT * FROM tblEmotions WHERE EmotionID = '$_POST[ID]'";
					$result = mysql_query($query) or die ("Error in query: $query. " . mysql_error());
					if (mysql_num_rows($result)>0);
					{
						$Info = mysql_fetch_array($result);
						$EmotionID = $Info['EmotionID'];
						$Name = $Info['EmotionName'];
						$Desc = $Info['EmotionDesc'];
						$Colour = $Info['EmotionColour'];
					}
				}
				if (isset($_POST[del])){
					$query = "DELETE FROM tblEmotions WHERE EmotionID = '$_POST[ID]'";
					$result = mysql_query($query) or die ("Error in query: $query. " . mysql_error());
				}
				if ($Edit == 1)
				{
					echo "<h3> Edit Emotion</h3>";
				}
				else
				{
				?>
					<div class="CollapsiblePanelTab" tabindex="0">
						<h3>+ Add Emotion</h3>
					</div>
					<div class="CollapsiblePanel">
						<div class="CollapsiblePanelContent">
				<?php
				}
				?>
					<form action="?Type=<?php echo $_GET[Type]; ?>&Option=<?php echo $_GET[Option]; ?>" method="POST" enctype="multipart/form-data" name="add Emotion" target="_self" id="add Emotion">
				<table width="100%" border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td width="150" align="right" valign="top"><h2>Name: </h2></td>
						<td><p>
							<?php if ($Edit == 1) { echo "<input name='ID' type='hidden' value='" . $EmotionID . "'>"; } ?>
							<input name="Name" type="text" size="30" maxlength="250" <?php if ($Edit == 1) { echo "value='" . $Name ."'"; } ?>> 
						</p></td>
					</tr>
					<tr>
						<td width="150" align="right" valign="top"><h2>Description:  </h2></td>
						<td>
							<!-- CKEditor -->							
							<textarea class="ckeditor" cols="80" id="Desc" name="Desc" rows="10"><?php echo $Desc; ?></textarea>
							<script type="text/javascript">
								//<![CDATA[
								CKEDITOR.replace( 'Desc',
								{
									toolbar :
									[
										{ name: 'document',    items : [ 'Source' ] },
										{ name: 'basicstyles', items : [ 'Bold','Italic','Underline','Subscript','Superscript','-','RemoveFormat' ] },
										{ name: 'insert',      items : [ 'Image','Table','HorizontalRule','SpecialChar'] },
										{ name: 'editing',     items : [ 'Find','Replace','-','SelectAll','-','SpellChecker' ] },
										'/',
										{ name: 'paragraph',   items : [ 'NumberedList','BulletedList','-','Outdent','Indent','-','Blockquote','CreateDiv','-','JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock','-','BidiLtr','BidiRtl' ] },
										{ name: 'links',       items : [ 'Link','Unlink','Anchor' ] },
										'/',
										{ name: 'styles',      items : [ 'Format','Font','FontSize' ] },
										{ name: 'colors',      items : [ 'TextColor'] },
										{ name: 'tools',       items : [ 'Maximize', 'ShowBlocks' ] }
									]
								} );
								//]]>
							</script>
						</td>
					</tr>
					<tr>
						<td width="150" align="right" valign="top"><h2>Colour: </h2></td>
						<td>
							<p>
								<input name="Colour" type="text" maxlength="6" size="6" id="Colour" <?php if ($Edit == 1) { echo "value='" . $Colour ."'"; } else { echo "value='#FFFFFF'"; } ?> />
				<div id="colourpicker"></div>
						</td>
					</tr>
					<tr>
						<td width="150" align="right" valign="top">&nbsp;</td>
						<td> <p align="right"><input type="submit" name="<?php if ($Edit == 1) { echo "editsubmit"; } else { echo "add"; } ?>"  value="  Submit  "></p></td>
					</tr>
				</table>
				</form>
				<?php
				if ($Edit != 1)
				{
				?>
						</div>
					</div>
					
					<div style='height:10px;'></div>
					<h3>Emotions: </h3>
					<?php
					$query = "SELECT * FROM tblEmotions ORDER BY EmotionRank, EmotionName";
					$result = mysql_query($query) or die ("Error in query: $query. " . mysql_error());
					if (mysql_num_rows($result) > 0)
					{
					?>
						<table width='100%' border='0' cellpadding='0' cellspacing='0'>
							<thead>
								<tr>
									<th>Name</th>
									<th width="40">colour</th>
									<th width="1%"></th>
									<th width="1%"></th>
								</tr>
							</thead>
							<tbody>
								<?php $x = 0;
								while($row = mysql_fetch_object($result))
								{ 
									$x++; ?>
								<tr<?php if ($x == 1) { echo " class='fill'"; } else { $x = 0; } ?>>
									<td><h2><?php echo $row->EmotionName; ?></h2></td>
									<td bgcolor="<?php echo $row->EmotionColour; ?>"></td>
									<td width="1%">
										<form action="?Type=<?php echo $_GET[Type]; ?>&Option=<?php echo $_GET[Option]; ?>" method="POST">
											<input name="ID" type="hidden" value="<?php echo $row->EmotionID; ?>"/>
											<input type="submit" name="edit"  value="edit">
										</form>
									</td>
									<td width="1%"><form action="?Type=<?php echo $_GET[Type]; ?>&Option=<?php echo $_GET[Option]; ?>" method="POST">
											<input name="ID" type="hidden" value="<?php echo $row->EmotionID; ?>"/>
											<input type="submit" name="del"  value=" del"onclick="return confirm('Are you sure you want to delete this Emotion?')">
										</form>
									</td>
								</tr>
								<?php
								}
								?>
							</tbody>
						</table>
					<?php
					}
				}
			}
			
						
			###########################################################################################
			########    END    ########################################################################
			###########################################################################################
			
			else
			{
				echo "'$_GET[Type]' section not yet working!!";
			}
			
			// Close Database connection //
			mysql_close($connect);
			?>
		
		</div><!-- maincontent -->
		
		<div class="footer"></div>
	
	</div><!-- container -->
	
</body>

<?php  
}
else
{
	echo "<body onLoad='document.forms.login.user.focus()'>";	
	echo "<div class='container'><br /><br />";
	echo "<div class='mainContent'>";
	displayLogin();
	echo "</div></div>";
	echo "</body>";
}
?>
</html>