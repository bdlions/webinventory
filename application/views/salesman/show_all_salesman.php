<h2>Salesman Details</h2>
<div class="clr search_details">
    <div class="clr span12">
        <div class="span12">
            <div class="row-fluid">
                <div class="tabbable">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#tabs1-pane1" data-toggle="tab">Salesman List</a></li>								
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="tabs1-pane1">
                            <p class="clr">
                            <div class="clr product_details sales_order_details specific span10">
                                <div style="width:3%;" class="blank_div span0">
                                    <h3 class="" style="background-image:none;">&nbsp;</h3>
                                    <?php foreach($salesman_list as $key => $salesman_info)
                                    {
                                    ?>
                                    <div class="wh_100"><p class="wh_100">&nbsp;</p></div>
                                    <?php
                                    }
                                    ?>
                                </div>
                                <div class="span1">
                                    <h3>Phone</h3>
                                    <?php foreach($salesman_list as $key => $salesman_info)
                                    {
                                    ?>
                                    <div class="wh_100"><?php echo $salesman_info['phone']?></div>
                                    <?php
                                    }
                                    ?>
                                </div>
                                <div class="span1">
                                    <h3>First Name</h3>
                                    <?php foreach($salesman_list as $key => $salesman_info)
                                    {
                                    ?>
                                    <div class="wh_100"><?php echo $salesman_info['first_name']?></div>
                                    <?php
                                    }
                                    ?>
                                </div>
                                <div class="span1">
                                    <h3>Last Name</h3>
                                    <?php foreach($salesman_list as $key => $salesman_info)
                                    {
                                    ?>
                                    <div class="wh_100"><?php echo $salesman_info['last_name']?></div>
                                    <?php
                                    }
                                    ?>
                                </div>
                                <div class="span1">
                                    <h3>Address</h3>
                                    <?php foreach($salesman_list as $key => $salesman_info)
                                    {
                                    ?>
                                    <div class="wh_100"><?php echo $salesman_info['address']?></div>
                                    <?php
                                    }
                                    ?>
                                </div>
                                <div class="span1">
                                    <h3>Manage</h3>
                                    <?php foreach($salesman_list as $key => $salesman_info)
                                    {
                                    ?>
                                    <div class="wh_100"><a href="<?php echo base_url("./user/update_salesman/".$salesman_info['user_id']);?>">Update</a></div>
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
