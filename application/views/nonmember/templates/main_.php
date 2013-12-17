<!DOCTYPE html>
<html lang="en" class="js no-flexbox canvas canvastext webgl no-touch geolocation postmessage websqldatabase indexeddb hashchange history draganddrop websockets rgba hsla multiplebgs backgroundsize borderimage borderradius boxshadow textshadow opacity cssanimations csscolumns cssgradients cssreflections csstransforms csstransforms3d csstransitions fontface generatedcontent video audio localstorage sessionstorage webworkers applicationcache svg inlinesvg smil svgclippaths">
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="Dedicated for selling textile product">
        <meta name="author" content="Nazmul Hasan, Alamgir Kabir, Noor Alam, Ziaur Rahman">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="og:site_name" content="apurbobrand" />
        <meta name="og:title" content="buy and sales" />
        <meta name="og:description" content="easy for sales, invetory and product disyplay" />	
        <meta name="keywords" content=""/>
        <title>"Enjoy Shopping!!!"</title>
		<link rel="stylesheet" type="text/css" href="./assets/css/bootstrap.css">
		<link rel="stylesheet" type="text/css" href="./assets/css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="./assets/css/bootstrap-combined.min.css">
		<link rel="stylesheet" type="text/css" href="./assets/css/bootstrap-responsive.css">
		<link rel="stylesheet" type="text/css" href="./assets/css/bootstrap-responsive.min.css">
		<link rel="stylesheet" type="text/css" href="./assets/css/docs.css">
		<link rel="stylesheet" type="text/css" href="./assets/css/jquery-ui.css">
		<link rel="stylesheet" type="text/css" href="./assets/css/prettify.css">
		<link rel="stylesheet" type="text/css" href="./assets/css/style.css">
		<link rel="stylesheet" type="text/css" href="./assets/css/styles.css">
		
		<link rel="stylesheet" href="./assets/slide/responsiveslides.css">
		<link rel="stylesheet" href="./assets/slide/demo.css">
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
		<script src="./assets/slide/responsiveslides.min.js"></script>
		<script language="javascript" type="text/javascript">
		function popitup(url) {
			newwindow=window.open(url,'name','height=500,width=550');
			if (window.focus) {newwindow.focus()}
			return false;
		}
		</script>
		<script>
		$(function () {
		  $("#slider4").responsiveSlides({
			auto: true,
			pager: false,
			nav: true,
			speed: 500,
			namespace: "callbacks",
			before: function () {
			  $('.events').append("<li>before event fired.</li>");
			},
			after: function () {
			  $('.events').append("<li>after event fired.</li>");
			}
		  });
		  $("#slider5").responsiveSlides({
			auto: true,
			pager: false,
			nav: true,
			speed: 500,
			namespace: "callbacks",
			before: function () {
			  $('.events').append("<li>before event fired.</li>");
			},
			after: function () {
			  $('.events').append("<li>after event fired.</li>");
			}
		  });
		  $("#slider6").responsiveSlides({
			auto: true,
			pager: false,
			nav: true,
			speed: 500,
			namespace: "callbacks",
			before: function () {
			  $('.events').append("<li>before event fired.</li>");
			},
			after: function () {
			  $('.events').append("<li>after event fired.</li>");
			}
		  });	
		});
		</script>
		  
    </head>
    <body screen_capture_injected="true" cz-shortcut-listen="true">
		<div class="container">
			<div class="row-fluid">
				<div class="clr span12">
					<div class="span4 fl logo-portion"><img src="./assets/images/home.jpg"></div>
					<div class="span4 signup-portion">
						<a href="./application/views/nonmember/templates/salesman_login.html" onclick="return popitup('./application/views/nonmember/templates/salesman_login.html')">Login</a>
					</div>
				</div>
				<div class="span12" style="margin-left:0;">
					<?php echo $contents; ?>
					<br/>
					<div id="wrapper">
						<div class="callbacks_container">
						  <ul class="rslides" id="slider4">
							<li>
							  <img src="http://localhost/webinventory/assets/slide/light_images_short/1.jpg" alt="">
							  <p class="caption">This is a caption</p>
							</li>
							<li>
							  <img src="http://localhost/webinventory/assets/slide/light_images_short/2.jpg" alt="">
							  <p class="caption">This is another caption</p>
							</li>
							<li>
							  <img src="http://localhost/webinventory/assets/slide/light_images_short/3.jpg" alt="">
							  <p class="caption">The third caption</p>
							</li>
						  </ul>
						</div>
					</div>
				</div>
				<div class="span12" style="margin-left:0;">					
					<div id="wrapper1">						
						<div class="callbacks_container">
						<h2>Top Selling Products</h2><br/>
						  <ul class="rslides" id="slider5">
							<li>
							  <img src="./assets/slide/light_images_short/4.jpg" alt="">
							  <p class="caption">
							  <strong>Product: Android</strong><br/>
							  Short Description<br/>
							  Price: $1500.00<br/>
							  <a href="#">View</a></p>
							</li>
							<li>
							  <img src="./assets/slide/light_images_short/5.jpg" alt="">
							  <p class="caption">
							  <strong>Product: Samsung</strong><br/>
							  Short Description<br/>
							  Price: $1600.00<br/>
							  <a href="#">View</a></p>
							</li>
							<li>
							  <img src="./assets/slide/light_images_short/6.jpg" alt="">
							  <p class="caption">
							  <strong>Product: Bada</strong><br/>
							  Short Description<br/>
							  Price: $1700.00<br/>
							  <a href="#">View</a></p>
							</li>
						  </ul>
						</div>
						<div class="callbacks_container">
						<h2>New Products</h2><br/>
						  <ul class="rslides" id="slider6">
							<li>
							  <img src="./assets/slide/light_images_short/4.jpg" alt="">
							  <p class="caption">
							  <strong>Product: Apple X Size</strong><br/>
							  Short Description<br/>
							  Price: $1500.00<br/>
							  <a href="#">View</a></p>
							</li>
							<li>
							  <img src="./assets/slide/light_images_short/5.jpg" alt="">
							  <p class="caption">
							  <strong>Product: Apple X Size</strong><br/>
							  Short Description<br/>
							  Price: $1600.00<br/>
							  <a href="#">View</a></p>
							</li>
							<li>
							  <img src="./assets/slide/light_images_short/6.jpg" alt="">
							  <p class="caption">
							  <strong>Product: Apple</strong><br/>
							  Short Description<br/>
							  Price: $1700.00<br/>
							  <a href="#">View</a></p>
							</li>
						  </ul>
						</div>
					</div>
				</div>
			</div>
		</div>
    </body>
</html>