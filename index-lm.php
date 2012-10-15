<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

	<title>Global Faces </title>
		<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />

	<link rel="stylesheet/less" type="text/css" href="css/layout.less">
	<link rel="stylesheet" type="text/css" href="css/animate.css" media="screen" />
    <script src="/js/LABjs-2.0.3/LAB.min.js"></script>
    <script>
        $LAB
            .setOptions({BasePath:'js/'})
            .script(
            'jquery.js'
            , 'jquery-ui.js'
            , 'underscore-min.js'
            , 'less-1.3.0.min.js'
            , 'jquery.hoverIntent.minified.js'
            , 'jquery.lazyload.min.js'
            , 'jquery.flightboard/jquery.flightboard.min.js'
        )
            .wait(function () {
            })
            .script(
            'custom.js'
        )
            .wait(function () {
                $(document).ready(function() {
                    initialLoad();
                });
            })

    </script>
</head>

<body>
	<div id="Container">
		<div id="Loading"  style="display: none; " ></div>
		<div id="Mask"></div>
		<div id="Menu">
			<div id="MenuPanel">
				<a class="button" href="##dummy">limit</a>
			</div>
			<div id="MenuTab">
				<a id="Open" class="open">FACES OF EMOTION</a>
				<a id="Close" style="display: none;" class="close">CLOSE</a>
				<div id="Result">38</div>
			</div>
		</div>
		
		<div id="Photos" style="display: block; ">
			<div id="MenuSpacer"></div>
			<div id="PhotosList">
				<ul>
				</ul>
			</div>
            <ul id="ActualPhotoList">
            </ul>

        </div>
		
		<div id="Footer">
			
			<div id="FooterPanel">
				<p>site by steven harris designs</p>
				<div class='form'><div class='closeForm'></div></div>
			</div>
			<div id="FooterTab"></div>
		</div>
	</div>
	
</body>
</html>