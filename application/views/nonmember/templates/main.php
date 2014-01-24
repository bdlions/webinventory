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
        <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/bootstrap3/css/home.css">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/bootstrap3/css/bootstrap.css">

        <link rel="stylesheet" href="./assets/slide/responsiveslides.css">
        <link rel="stylesheet" href="./assets/slide/demo.css">
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
        <script src="./assets/slide/responsiveslides.min.js"></script>
        <script language="javascript" type="text/javascript">
            function popitup(url) {
                newwindow = window.open(url, 'name', 'height=500,width=550');
                if (window.focus) {
                    newwindow.focus()
                }
                return false;
            }
        </script>
        <script>
            $(function() {
                $("#slider4").responsiveSlides({
                    auto: true,
                    pager: false,
                    nav: true,
                    speed: 500,
                    namespace: "callbacks",
                    before: function() {
                        $('.events').append("<li>before event fired.</li>");
                    },
                    after: function() {
                        $('.events').append("<li>after event fired.</li>");
                    }
                });
                $("#slider5").responsiveSlides({
                    auto: true,
                    pager: false,
                    nav: true,
                    speed: 500,
                    namespace: "callbacks",
                    before: function() {
                        $('.events').append("<li>before event fired.</li>");
                    },
                    after: function() {
                        $('.events').append("<li>after event fired.</li>");
                    }
                });
                $("#slider6").responsiveSlides({
                    auto: true,
                    pager: false,
                    nav: true,
                    speed: 500,
                    namespace: "callbacks",
                    before: function() {
                        $('.events').append("<li>before event fired.</li>");
                    },
                    after: function() {
                        $('.events').append("<li>after event fired.</li>");
                    }
                });
            });
        </script>
        <link rel="stylesheet" href="./assets/extra/pinhp-base.css" type="text/css">
        <link rel="stylesheet" href="./assets/extra/ui.css" type="text/css">  
    </head>
    <body screen_capture_injected="true" cz-shortcut-listen="true">
        <div class="container">
            <div class="row-fluid">
                <div class="clr span12">
                    <div class="gaf-container">
                        <div class="simple-hp template-b " data-abtest="2" data-has_footer="true" data-has_image_hover="true">
                            <div class="main-bg">
                                <div class="container">
                                    <header>
                                        <section class="login-prompt" style="padding: 24px 0;">
                                            <a href="#login" class="login-btn section-toggle login-bt">Login</a>
                                            <a href="#signup" class="signup-btn section-toggle signup-bt">Signup</a>
                                        </section>
                                        <div class="row">
                                            <div class="logo" style="background-size: 90%;margin: 10px 0;height: 46px;"><a href="#objective" class="section-toggle" id="logo-back-bt"></a></div>
                                        </div>
                                    </header>
                                </div>
                            </div>
                            <div data-state="login" class="sections-bg login-bg" id="sections-bg">
                                <div class="container">
                                    <section style="opacity: 1; display: block;" id="login" class="login visible">
                                        <div class="row">
                                            <div class="span12" id="login-form-div">
                                                <h1 style="color:#000 !important;">login Block</h1>
                                            </div>
                                        </div>
                                    </section>
                                    <section id="signup" class="signup hidden">
                                        <div class="row">
                                            <div class="span12">
                                                <h1 style="color:#000 !important;">Sign up Block</h1>
                                            </div>
                                        </div>
                                    </section>
                                </div>
                            </div>
                            <section class="gallery">
                                <div class="container">
                                    <div class="container">
                                        <div class="row-fluid">											
                                            <div class="span12" style="margin-left:0;">
<?php echo $contents; ?>
                                                <br/>
                                                <div id="wrapper">
                                                    <div class="callbacks_container">
                                                        <ul class="rslides" id="slider4">
                                                            <li>
                                                                <img src="./assets/slide/light_images_short/7.jpg" alt="">
                                                                <p class="caption">This is a caption</p>
                                                            </li>
                                                            <li>
                                                                <img src="./assets/slide/light_images_short/8.jpg" alt="">
                                                                <p class="caption">This is another caption</p>
                                                            </li>
                                                            <li>
                                                                <img src="./assets/slide/light_images_short/9.jpg" alt="">
                                                                <p class="caption">The third caption</p>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="span12" style="margin-left:0;margin-bottom: 15px;">					
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
                                            <div class="span12 footer-portion">
                                                <div class="span4 fl" style="float:left !important;text-align:left;">@2013, <a href="#">bdlions</a></div>
                                                <div class="span4 copyright">
                                                    <ul>
                                                        <li><a href="#">home</a></li>
                                                        <li><a href="#">Privacy & Policy</a></li>
                                                        <li><a href="#">Terms & Conditions</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>
                        </div>
                    </div>
                </div>
            </div>
        </div>			
    </body>
</html>
<script type="text/javascript">
    var _sf_startpt = (new Date()).getTime();
    function getCookieBase() {
        return 'GETAFREE';
    }
</script>
<script src="./assets/extra/jquery-1.js" type="text/javascript"></script>
<script src="./assets/extra/formTools.js" type="text/javascript"></script>
<script src="./assets/extra/underscore.js" type="text/javascript"></script>
<script src="./assets/extra/bootstrap.js" type="text/javascript"></script>
<script src="./assets/extra/bootstrap-popover.js" type="text/javascript"></script>
<script src="./assets/extra/modernizr2.js" type="text/javascript"></script>
<script type="text/javascript">
    var freelancer = freelancer || {};
    var flns = flns || {};
    window.console = window.console || {
        log: function() {
            return true;
        },
        trace: function() {
            return true;
        }
    };
    var is_bootstrap = true;
    (function(ns) {
        ns.config = {};
        ns.config.cdn_urls = ["cdn2.f-cdn.com", "cdn3.f-cdn.com", "cdn5.f-cdn.com", "cdn6.f-cdn.com"];
        ns.config.cookie_base = 'GETAFREE';
        ns.config.notify_server = '//notifications.freelancer.com';
        ns.config.currency = '1';
        ns.config.site_name = 'Freelancer.com';
        ns.config.cookie_domain = '.freelancer.com';
    })(flns);
    var ssl_base_url = 'https://www.freelancer.com';
</script>

<script src="./assets/extra/global.js" type="text/javascript"></script>
<script src="./assets/extra/require.js" type="text/javascript"></script>
<script type="text/javascript">
    (function() {
        JQ = jQuery.noConflict();
        JQ(document).ready(function() {
            JQ('body').on('click', '#tabmanager_pmbs', function(e) {
                _gaq.push(['_trackEvent', 'notification', 'click', 'pmb']);
            });
            JQ('body').on('click', '#tabmanager_notify', function(e) {
                _gaq.push(['_trackEvent', 'notification', 'click', 'notify']);
            });
        });
    })();
</script>
<script type="text/javascript">
    (function(document, location) {
        var script = document.createElement('script');
        script.src = location.protocol + '//s.fl-ads.com/build/js/ads/serve/main/parent/adq.js?v=0827eeb3e1b7ab79e44f00e0da09b866&amp;m=2';
        script.async = true;
        script.type = 'text/javascript';

        var position = document.getElementsByTagName('script')[0];
        position.parentNode.insertBefore(script, position);
    }(document, window.location));
</script>
<!--  -->
<script src="./assets/extra/main-welcome_a.js" data-requiremodule="//cdn3.f-cdn.com/build/js/main-welcome_a.js?v=175f01e8880e194f9327b10e2dffb86a&amp;amp;m=2" data-requirecontext="_" async="" charset="utf-8" type="text/javascript"></script>