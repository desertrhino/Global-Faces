<script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
<style>
ul{
	margin: 0;
	padding: 0;
	list-style: none;
}
li{
	float: left;
	position: relative;
	width: 107px;
	height: 127px;
	-webkit-perspective: 600px;
}
.ticker{
	position: absolute;
	top:0;
	left: 0;
	width: 107px;
	height: 127px;	
}
.currentimage{
	-backface-visibility: hidden;
}
.nextimage{
	z-index: 1;
}
@-webkit-keyframes spinner {
	from { -webkit-transform: rotateX(0deg);    }
	to   { -webkit-transform: rotateX(-360deg); }
}
@-webkit-keyframes spinner2 {
	from { -webkit-transform: rotateX(-360deg);    }
	to   { -webkit-transform: rotateX(0deg); }
}
.currentimage{
    -webkit-animation-name: spinner;
    -webkit-animation-timing-function: linear;
    -webkit-animation-iteration-count: infinite;
    -webkit-animation-duration: 2s;
    -webkit-transform-style: preserve-3d;
    -webkit-animation-delay:2s;
    -webkit-animation-iteration-count: 0s;
}
.nextimage{
    -webkit-animation-name: spinner2;
    -webkit-animation-timing-function: linear;
    -webkit-animation-iteration-count: infinite;
    -webkit-animation-duration: 2s;
    -webkit-transform-style: preserve-3d;
    -webkit-animation-delay:2s;
    -webkit-animation-iteration-count: 4s;
}
.imagetop{
	height: 63px;
	width: 107px;
}
.imagebottom{
	position: absolute;
	top:63px;
	height: 64px;
	width: 107px;
	background-position-y: -63px;
}
</style>
<ul>	<li>
		<img src="faces/ticker_mock.gif" width="107" height="127">
	</li>
	<li>
		<div class="ticker currentimage">
			<div class="imagetop" style="background-image:url(faces/thumbs/face_0001.jpg)"></div>
			<div class="imagebottom" style="background-image:url(faces/thumbs/face_0001.jpg)"></div>
		</div>
		<div class="ticker nextimage">
			<div class="imagetop" style="background-image:url(faces/thumbs/face_0002.jpg)"></div>
			<div class="imagebottom" style="background-image:url(faces/thumbs/face_0002.jpg)"></div>
		</div>
	</li>
	<li>
		<img src="faces/ticker_mock.gif" width="107" height="127">
	</li>
</ul>