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
        <title>
            <?php
            if (empty($title)) {
                echo "Inventory management";
            } else {
                echo $title;
            }
            ?>
        </title>
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/jquery-ui.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/styles.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/bootstrap.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/bootstrap.min.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/bootstrap-responsive.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/bootstrap-responsive.min.css" />
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/datepicker.css" >
        <link href='http://fonts.googleapis.com/css?family=Dosis:200' rel='stylesheet' type='text/css'>
        <link href='http://fonts.googleapis.com/css?family=Ubuntu' rel='stylesheet' type='text/css'>
        <link href="<?php echo base_url(); ?>assets/css/bootstrap.min.css" rel="stylesheet">
        
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/bootstrap.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/bootstrap.min.js"></script>
        <!--************************************************************ Drop Down Menu  ****************************************-->
        <script src="<?php echo base_url(); ?>assets/js/ga.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/jquery-latest.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/bootstrap.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/twitter-bootstrap-hover-dropdown.js"></script>
        
        
        <!--***************************************************************************************************-->
        <script>
            $('.carousel').carousel({
                interval: 2000
            });
        </script>
        <style type="text/css">
            .carousel-control{
                margin-top:200px !important;
                width:5% !important;
                background: rgba(255,255,255,0.8) !important;
                border-radius: 5px !important;
                -webkit-border-radius: 5px !important;
                -moz-border-radius: 5px !important;
                text-shadow:0 0px 0px rgba(0,0,0,0) !important;
            }
            .carousel-caption h4, 
            .carousel-caption p {
                margin: 0 0 5px !important;
                color: #ffffff !important;
                font-weight: bold !important;
            }
        </style>
        <!--************************************************************ Drop Down Menu  ****************************************-->

        <!-- Example plugin: Prettify -->
        <script src="<?php echo base_url(); ?>assets/js/prettify.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/bootstrap-datepicker.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/widgets.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/bootstrap-transition.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/bootstrap-alert.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/bootstrap-modal.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/bootstrap-dropdown.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/bootstrap-scrollspy.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/bootstrap-tab.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/bootstrap-tooltip.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/bootstrap-popover.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/bootstrap-button.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/bootstrap-collapse.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/bootstrap-carousel.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/bootstrap-typeahead.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/bootstrap-affix.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/holder/holder.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/google-code-prettify/prettify.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/application.js"></script>
        
        <!-- Initialize Scripts -->
        <script>
            // Activate Google Prettify in this page
            addEventListener('load', prettyPrint, false);

            $(document).ready(function() {

                // Add prettyprint class to pre elements
                $('pre').addClass('prettyprint');

            }); // end document.ready
        </script>
        <script>
            $(function() {
                var defaults = {},
                        defaults_form = $('<form>', {html: $('.sandbox-form').html()})
                $.each(defaults_form.serializeArray(), function(i, e) {
                    if (e.name in defaults)
                        defaults[e.name] += ',' + e.value;
                    else
                        defaults[e.name] = e.value;
                });
                delete defaults.markup;

                function fix_indent(s) {
                    var lines = s.split(/\r?\n/g);
                    while (/^\s*$/.test(lines[0]))
                        lines.shift();
                    while (/^\s*$/.test(lines[lines.length - 1]))
                        lines.pop();
                    var indent = /^\s*/.exec(lines[0])[0],
                            deindent = new RegExp('^' + indent);
                    for (var i = 0; i < lines.length; i++)
                        lines[i] = lines[i].replace(deindent, '');
                    return lines.join('\n');
                }

                function build_code() {
                    var form = $('.sandbox-form'),
                            values = {};
                    $.each(form.serializeArray(), function(i, e) {
                        if (e.name in values)
                            values[e.name] += ',' + e.value;
                        else
                            values[e.name] = e.value;
                    });

                    var html = fix_indent($('[name=markup][value=' + values.markup + ']').siblings('script.html').html());
                    var selector = $('[name=markup][value=' + values.markup + ']').siblings('script.selector').html().replace(/^\s+|\s+$/g, '');
                    delete values.markup;

                    var js = "$('#sandbox-container " + selector + "').datepicker({\n",
                            val;
                    for (var opt in $.extend({}, defaults, values)) {
                        if (values[opt] != defaults[opt]) {
                            val = values[opt];
                            if (opt == 'daysOfWeekDisabled')
                                val = '"' + val + '"'
                            else if (opt == 'beforeShowDay')
                                val = function(date) {
                                    if (date.getMonth() == (new Date()).getMonth())
                                        switch (date.getDate()) {
                                            case 4:
                                                return {
                                                    tooltip: 'Example tooltip',
                                                    classes: 'active'
                                                };
                                            case 8:
                                                return false;
                                            case 12:
                                                return "green";
                                        }
                                }
                            else if (val == 'on' || val == 'true')
                                val = 'true';
                            else if (val === void 0 || val == 'false')
                                val = 'false';
                            else if (parseInt(val) == val)
                                val = val;
                            else
                                val = '"' + val + '"'
                            js += "    " + opt + ": " + val + ",\n"
                        }
                    }
                    if (js.slice(-2) == ",\n")
                        js = js.slice(0, -2) + "\n";
                    js += "});";

                    return [html, js];
                }
                function update_code() {
                    var code = build_code(),
                            html = code[0],
                            js = code[1];

                    var print_html = html.replace(/</g, '&lt;').replace(/>/g, '&gt;')
                    $('#sandbox-html').html(prettyPrintOne(print_html, 'html', true));
                    $('#sandbox-js').html(prettyPrintOne(js, 'js', true));
                }
                function update_sandbox() {
                    var code = build_code(),
                            html = code[0],
                            js = code[1];

                    $('#sandbox-container > :first-child').datepicker('remove');
                    $('#sandbox-container').html(html);
                    eval(js);
                }
                function update_url() {
                    if (history.replaceState) {
                        var query = '?' + $('.sandbox-form').serialize();
                        history.replaceState(null, null, query + '#sandbox');
                    }
                }
                function update_all() {
                    update_code();
                    update_sandbox();
                    update_url();
                }

                $('.sandbox-form')
                        .submit(function() {
                    return false;
                })
                        .keydown(update_all)
                        .keyup(update_all)
                        .click(function(e) {
                    update_code();
                    update_sandbox();
                    if (!$(e.target).is('button[type=reset]'))
                        update_url();
                });

                $('.sandbox-form button[type=reset]').click(function() {
                    $('.sandbox-form')[0].reset();
                    update_code();
                    update_sandbox();
                    history.replaceState && history.replaceState(null, null, '?#sandbox');
                });

                setTimeout(function() {
                    // Load form state from url if possible
                    var search = document.location.search.replace(/^\?/, '');
                    if (search) {
                        search = search.split('&');
                        var values = {};
                        for (var i = 0, opt, val; i < search.length; i++) {
                            opt = search[i].split('=')[0];
                            val = search[i].split('=')[1];
                            if (opt in values)
                                values[opt] += ',' + val;
                            else
                                values[opt] = val;
                        }

                        for (var opt in $.extend({}, defaults, values)) {
                            var el = $('[name=' + opt + ']'),
                                    val = unescape(values[opt]);
                            if (el.is(':checkbox')) {
                                if (el.length > 1) {
                                    var vals = val.split(',');
                                    $('[name=' + opt + ']').prop('checked', false);
                                    for (var i = 0; i < vals.length; i++)
                                        $('[name=' + opt + '][value=' + vals[i] + ']').prop('checked', true);
                                }
                                else if (val === 'undefined')
                                    el.prop('checked', false);
                                else
                                    el.prop('checked', true);
                            }
                            else if (el.is(':radio')) {
                                el.filter('[value=' + val + ']').prop('checked', true);
                            }
                            else
                                el.val(val);
                        }
                    }

                    // Don't replaceState the url on pageload
                    update_code();
                    update_sandbox();
                }, 300);

                // Analytics event tracking
                // What options are people interested in?
                $('.sandbox-form input, .sandbox-form select').change(function(e) {
                    var $this = $(this),
                            val, opt;
                    opt = $this.attr('name');
                    val = $this.val();
                    if ($this.is(':checkbox') && val == 'on')
                        val = $this.is(':checked') ? "on" : "off";
                    _gaq.push(['_trackEvent', 'Sandbox', 'Option: ' + opt, val]);
                });
                // Do they even use the reset button?
                $('.sandbox-form button[type=reset]').click(function() {
                    _gaq.push(['_trackEvent', 'Sandbox', 'Reset']);
                });

                var flag = 0, mousedown = false, delta = 0, x = 0, y = 0, dx, dy;
                // How do they interact with the HTML display?  Do they select
                // the code, do they try to edit it (I'd want to!)?
                $("#sandbox-html").mousedown(function(e) {
                    mousedown = true;
                    delta = 0;
                    x = e.clientX;
                    y = e.clientY;
                });
                $("#sandbox-html").mousemove(function(e) {
                    if (mousedown) {
                        dx = Math.abs(e.clientX - x);
                        dy = Math.abs(e.clientY - y);
                        delta = Math.max(dx, dy);
                    }
                });
                $("#sandbox-html").mouseup(function() {
                    if (delta <= 10)
                        _gaq.push(['_trackEvent', 'Sandbox', 'HTML Clicked']);
                    else
                        _gaq.push(['_trackEvent', 'Sandbox', 'HTML Selected']);
                    delta = 0;
                    mousedown = false;
                });

                // How do they interact with the JS display?  Do they select
                // the code, do they try to edit it (I'd want to!)?
                $("#sandbox-js").mousedown(function(e) {
                    mousedown = true;
                    delta = 0;
                    x = e.clientX;
                    y = e.clientY;
                });
                $("#sandbox-js").mousemove(function(e) {
                    if (mousedown) {
                        dx = Math.abs(e.clientX - x);
                        dy = Math.abs(e.clientY - y);
                        delta = Math.max(dx, dy);
                    }
                });
                $("#sandbox-js").mouseup(function() {
                    if (delta <= 10)
                        _gaq.push(['_trackEvent', 'Sandbox', 'JS Clicked']);
                    else
                        _gaq.push(['_trackEvent', 'Sandbox', 'JS Selected']);
                    delta = 0;
                    mousedown = false;
                });
            });
        </script>
        <script src="<?php echo base_url(); ?>assets/js/jquery-ui.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/order/common.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/order/product.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/order/purchase.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/order/sale.js"></script>
    </head>
    <body screen_capture_injected="true" cz-shortcut-listen="true">
        <div class="top_nav container">
            <?php $this->load->view("salesman/templates/top_nav"); ?>
        </div>
        <div class="clr hundrd container">
            <div class="row-fluid">
                <?php $this->load->view("salesman/templates/left"); ?>
                <div class="ninetypercnt fr right_div span11">
                    <?php //$this->load->view("salesman/home"); ?>
                    <?php echo $contents?>
                </div>
            </div>
        </div>
        <?php $this->load->view("salesman/templates/footer"); ?>	
    </body>
</html>