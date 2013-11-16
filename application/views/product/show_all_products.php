<h2>Product Details</h2>
<div class="clr search_details">
    <div class="clr span12">
        <div class="span12">
            <div class="row-fluid">
                <div class="tabbable">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#tabs1-pane1" data-toggle="tab">Product List</a></li>								
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="tabs1-pane1">
                            <p class="clr">
                            <div class="clr product_details sales_order_details specific span10">
                                <div style="width:3%;" class="blank_div span0">
                                    <h3 class="" style="background-image:none;">&nbsp;</h3>
                                    <?php foreach($product_list as $key => $prodduct_info)
                                    {
                                    ?>
                                    <div class="wh_100"><p class="wh_100">&nbsp;</p></div>
                                    <?php
                                    }
                                    ?>
                                </div>
                                <div class="span1">
                                    <h3>Product ID</h3>
                                    <?php foreach($product_list as $key => $prodduct_info)
                                    {
                                    ?>
                                    <div class="wh_100"><?php echo $prodduct_info['id']?></div>
                                    <?php
                                    }
                                    ?>
                                </div>
                                <div class="span1">
                                    <h3>Product Name</h3>
                                    <?php foreach($product_list as $key => $prodduct_info)
                                    {
                                    ?>
                                    <div class="wh_100"><?php echo $prodduct_info['name']?></div>
                                    <?php
                                    }
                                    ?>
                                </div>
                                <div class="span1">
                                    <h3>Product Code</h3>
                                    <?php foreach($product_list as $key => $prodduct_info)
                                    {
                                    ?>
                                    <div class="wh_100"><?php echo $prodduct_info['code']?></div>
                                    <?php
                                    }
                                    ?>
                                </div> 
                                <div class="span1">
                                    <h3>Unit Price</h3>
                                    <?php foreach($product_list as $key => $prodduct_info)
                                    {
                                    ?>
                                    <div class="wh_100"><?php echo $prodduct_info['unit_price']?></div>
                                    <?php
                                    }
                                    ?>
                                </div>                                 
                                <div class="span1">
                                    <h3>Manage</h3>
                                    <?php foreach($product_list as $key => $prodduct_info)
                                    {
                                    ?>
                                    <div class="wh_100"><a href="<?php echo base_url("./product/update_product/".$prodduct_info['id']);?>">Update</a></div>
                                    <?php
                                    }
                                    ?>
                                </div>												
                                <p class="clr">&nbsp;</p>
                            </div>
                            </p>
                        </div>
                        
                    </div>
                </div>
            </div>
            <hr>
        </div>
    </div>				
    <p class="clr">&nbsp;</p>
</div>
