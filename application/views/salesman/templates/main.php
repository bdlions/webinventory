<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">
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
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/styles.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/bootstrap.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/bootstrap-responsive.min.css" />
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/datepicker.css" >
        <link href='http://fonts.googleapis.com/css?family=Dosis:200' rel='stylesheet' type='text/css'>
        <link href='http://fonts.googleapis.com/css?family=Ubuntu' rel='stylesheet' type='text/css'>

        <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
        <script src="<?php echo base_url() ?>assets/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/bootstrap-carousel.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/bootstrap-datepicker.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/application.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/order/common.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/order/product.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/order/purchase.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/order/sale.js"></script>
    </head>

    <body>



    <body screen_capture_injected="true" cz-shortcut-listen="true">
        <div class="top_nav container">
            <?php $this->load->view("salesman/templates/top_nav"); ?>
        </div>
        <div class="clr hundrd container">
            <div class="row-fluid">
                <?php $this->load->view("salesman/templates/left"); ?>
                <div class="ninetypercnt fr right_div span11">
                    <?php echo $contents?>
                </div>
            </div>
        </div>
        <?php $this->load->view("salesman/templates/footer"); ?>	
    </body>

</body>
</html>
