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

<!------------------------  Block for Slider ------------------------------------>
                <link rel="stylesheet" type="text/css" href="./assets/bootstrap3/css/bootstrap.min.css">
		<link rel="stylesheet" href="./assets/bootstrap3/css/custom_styles.css">		
		<script src="./assets/js/jquery-1.10.2.min.js"></script>
		<script src="./assets/slide/responsiveslides.min.js"></script>
		<script src="./assets/slide/jquery-1.js" type="text/javascript"></script>
		<script src="./assets/slide/formTools.js" type="text/javascript"></script>
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
<!------------------------  Block for Slider ------------------------------------>
        
    </head>
    <body>
        <div class ="container">
            <div class ="row">
                <!-- Header part -->
            </div>
            <div class="row">
                <?php echo $contents ?>
            </div>
            <div class ="row">
                <?php $this->load->view("salesman/templates/footer"); ?>
            </div>
        </div>
    </body>
</html>

