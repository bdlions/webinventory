<h2>Shop Details</h2>
<div class="clr search_details">
    <div class="clr span12">
        <div class="span12">
            <div class="row-fluid">
                <div class="tabbable">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#tabs1-pane1" data-toggle="tab">Shop List</a></li>								
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="tabs1-pane1">
                            <p class="clr">
                            <div class="clr product_details sales_order_details specific span10">
                                <div style="width:3%;" class="blank_div span0">
                                    <h3 class="" style="background-image:none;">&nbsp;</h3>
                                    <?php foreach($shop_list as $key => $shop_info)
                                    {
                                    ?>
                                    <div class="wh_100"><p class="wh_100">&nbsp;</p></div>
                                    <?php
                                    }
                                    ?>
                                </div>
                                <div class="span1">
                                    <h3>Shop ID</h3>
                                    <?php foreach($shop_list as $key => $shop_info)
                                    {
                                    ?>
                                    <div class="wh_100"><?php echo $shop_info['id']?></div>
                                    <?php
                                    }
                                    ?>
                                </div>
                                <div class="span1">
                                    <h3>Shop No</h3>
                                    <?php foreach($shop_list as $key => $shop_info)
                                    {
                                    ?>
                                    <div class="wh_100"><?php echo $shop_info['shop_no']?></div>
                                    <?php
                                    }
                                    ?>
                                </div>
                                <div class="span1">
                                    <h3>Shop Name</h3>
                                    <?php foreach($shop_list as $key => $shop_info)
                                    {
                                    ?>
                                    <div class="wh_100"><?php echo $shop_info['name']?></div>
                                    <?php
                                    }
                                    ?>
                                </div>
                                <div class="span1">
                                    <h3>Shop Phone</h3>
                                    <?php foreach($shop_list as $key => $shop_info)
                                    {
                                    ?>
                                    <div class="wh_100"><?php echo $shop_info['shop_phone']?></div>
                                    <?php
                                    }
                                    ?>
                                </div>
                                <div class="span1">
                                    <h3>Shop Address</h3>
                                    <?php foreach($shop_list as $key => $shop_info)
                                    {
                                    ?>
                                    <div class="wh_100"><?php echo $shop_info['address']?></div>
                                    <?php
                                    }
                                    ?>
                                </div>
                                <div class="span1">
                                    <h3>Manage</h3>
                                    <?php foreach($shop_list as $key => $shop_info)
                                    {
                                    ?>
                                    <div class="wh_100"><a href="<?php echo base_url("./shop/update_shop/".$shop_info['id']);?>">Update</a></div>
                                    <?php
                                    }
                                    ?>
                                </div>                                
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
