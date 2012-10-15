<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

	<title>Global Faces </title>
		<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />

	<link rel="stylesheet/less" type="text/css" href="css/layout.less">
	<link rel="stylesheet" type="text/css" href="css/animate.css" media="screen" />
	<script src="http://code.jquery.com/jquery.js"></script> 
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.5/jquery-ui.js"></script>
	<script src="js/less-1.3.0.min.js" type="text/javascript"></script>
	<script type="text/javascript" src="js/jquery.hoverIntent.minified.js"></script>
	<script type="text/javascript" src="js/jquery.lazyload.min.js"></script>
	
</head>

<body>
	<div id="Container">
		<div id="Loading"></div>
		<div id="Mask"></div>
		<div id="Menu">
			<div id="MenuPanel">
				<a class="button" href="##dummy">limit</a>
			</div>
			<div id="MenuTab">
				<a id="Open" class="open">FACES OF EMOTION</a>
				<a id="Close" style="display: none;" class="close">CLOSE</a>
				<div id="Result"></div>
			</div>
		</div>
		
		<div id="Photos">
			<div id="MenuSpacer"></div>
			<div id="PhotosList">
				<ul>
					<l><img id='1' src='faces/face_0001.jpg' alt='imagename' /></li>
				</ul>
			</div>
		</div>
		
		<div id="Footer">
			
			<div id="FooterPanel">
				<p>site by steven harris designs</p>
				<div class='form'><div class='closeForm'></div></div>
			</div>
			<div id="FooterTab"></div>
		</div>
	</div>
	
	<script type="text/javascript">
		$(function() {
		
			$('#MenuPanel').on("click", ".botton", function(e) {
				$('.all').quicksand( $('.showothers li'), {
					duration: 3000,
					attribute: 'data-id'
				});
				e.preventDefault();
			});
		
			// ##### MENU #####
			// hover information panels
			$("#Menu").hoverIntent(showMenu,hideMenu);
			// Expand Menu touch screen
			$("#Open").click(showMenu);	
			// Collapse Menu touch screen
			$("#Close").click(hideMenu);
			
			// ##### FOOTER #####
			// hover information panels
			$("#Footer").hoverIntent(showFoot,hideFoot);
			
			// ##### PHOTOS #####
			// thumbnail click
			$('#Photos').on("click", "li", function() {
				$('#Mask').fadeIn('200');
				var show = $(this).children("img").attr("id");
				var id = $(this).attr("class");
				$(this).addClass('current');
				zoomImage();
				$("."+id).children("img").not(".show").fadeOut('200');
				$('#Mask').addClass(id);
				$('#Result').text(show);
				//$("#"+show).hide();
				$("#form"+show).fadeIn('200');
				$("#Photos").removeClass("show");
			});
			/*$('#Photos').on("click", "li", function() {
				$('#Mask').fadeIn('200');
				var show = $(this).children("img").attr("id");
				var id = $(this).attr("class")
				$("."+id).children("img").animate({
				height: 1,
				}, 200);
				$('#Mask').addClass(id);
				
				$(".form").fadeOut('200');
				$('#Result').text(show);
				//$("#"+show).hide();
				$("#form"+show).fadeIn();
			});*/
			// close form
			$('#Photos').on("click", ".closeForm", function() {
				closeForm();
			});
			$('#Mask').click( function() {
				closeForm();
			});
			$('.closeForm').click( function() {
				closeForm();
			});
			
		}); // close document.ready
		// ##### MENU #####
		function showMenu(){
			$("#MenuPanel").slideDown(300);
			$("#MenuTab a").toggle();
		}
		
		function hideMenu(){
			$("#MenuPanel").slideUp(300);
			$("#MenuTab a").toggle();
		}
		
		// ##### MENU #####
		function showFoot(){
			$("#FooterPanel").slideDown(300);
		}
		
		function hideFoot(){
			$("#FooterPanel").slideUp(300);
		}
		
		function arangePhotos(){
			$('#Loading').show();
			var $broswerWidth = $(window).width();
			var $broswerHeight = $(window).height();
			var $ImgWidth = $('#Photos img:visible:first').width();
			var $ImgHeight = $('#Photos img:visible:first').height();
			var $ImagesAccross = Math.floor($broswerWidth / $ImgWidth);
			var $ImagesDown = Math.floor($broswerHeight / $ImgHeight);
			var $ImagesDisplayed = $ImagesAccross * $ImagesDown;
			var $NewWidth = $ImagesAccross * $ImgWidth;
			$('#Result').text($NewWidth);
			$("#PhotosList").load("loadphotos.php", {show: $ImagesDisplayed, accross: $ImagesAccross });
			$('#Loading').fadeOut('200');
			$('#Photos img').addClass('animated flipInY');
			$('#PhotosList').css("width", $NewWidth);
		}
		function zoomImage(){
			var $broswerWidth = $(window).width();
			var $broswerHeight = $(window).height();
			
			var $Offset = $(".current img").offset();
			var $ImgTop = $Offset.top;
			var $ImgLeft = $Offset.left;				
			var $ImgWidth = $(".current").width();
			var $ImgHeight = $(".current").height();
			var $FinalTop = ($broswerHeight / 2) - 149;
			var $FinalLeft = ($broswerWidth / 2) - 249;
			
			var $MoveTop = $FinalTop - $ImgTop;
			var $MoveLeft = $FinalLeft - $ImgLeft;
			
			$('#Result').text("(Final Width = "+$FinalLeft+"("+$broswerWidth+" / 2) - 149) - ImgLeft:("+$ImgLeft+" = MoveLeft"+$MoveLeft);
			
			$(".current").children("img").addClass('show');
			$(".current").children("img").css("left", $ImgLeft).css("top", $ImgTop);
			
			$(".current").children("img").animate({
				left:$FinalLeft,
				top:$FinalTop,
				width:253,
				height:300,
			}, 600).fadeOut();
			$(".current").children("img").animate({
				left:$ImgLeft,
				top:$ImgTop,
				width:$ImgWidth,
				height:$ImgHeight,
			});
			$("#PhotosList li").removeClass("current");
		}
		function closeForm(){			
			var id = $("#Mask").attr("class");
			$("#Mask").fadeOut('200');
			$(".form").fadeOut('200');
			$("."+id).children("img").fadeIn('200');
			$("#PhotosList img").removeClass("show")
			$("#Mask").removeClass(id);
		}
		$(window).load(function() {
			$('#Loading').fadeOut('200'); 
			$('#Photos').fadeIn('2000');
			arangePhotos();

		});
		
		var rtime = new Date(1, 1, 2000, 12,00,00);
		var timeout = false;
		var delta = 200;
		$(window).resize(function() {
		    rtime = new Date();
		    if (timeout === false) {
		        timeout = true;
		        setTimeout(resizeend, delta);
		    }
		});
		
		function resizeend() {
		    if (new Date() - rtime < delta) {
		        setTimeout(resizeend, delta);
		    } else {
		        timeout = false;		        
				$('#Loading').fadeOut('200');
				$('#Mask').fadeOut('200');
				arangePhotos();
		    }               
		}
	</script>
</body>
</html>