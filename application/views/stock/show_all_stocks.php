<h2>Stock Details</h2>
<div class="clr search_details">
    <div class="clr span12">
        <div class="span12">
            <div class="row-fluid">
                <div class="tabbable">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#tabs1-pane1" data-toggle="tab">Stock List</a></li>								
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="tabs1-pane1">
                            <p class="clr">
                            <div class="clr product_details sales_order_details specific span10">
                                <div style="width:3%;" class="blank_div span0">
                                    <h3 class="" style="background-image:none;">&nbsp;</h3>
                                    <?php foreach($stock_list as $key => $stock_info)
                                    {
                                    ?>
                                    <div class="wh_100"><p class="wh_100">&nbsp;</p></div>
                                    <?php
                                    }
                                    ?>
                                </div>
                                <div class="span1">
                                    <h3>Shop Name</h3>
                                    <?php foreach($stock_list as $key => $stock_info)
                                    {
                                    ?>
                                    <div class="wh_100"><?php echo $stock_info['shop_name']?></div>
                                    <?php
                                    }
                                    ?>
                                </div>
                                <div class="span1">
                                    <h3>Product Name</h3>
                                    <?php foreach($stock_list as $key => $stock_info)
                                    {
                                    ?>
                                    <div class="wh_100"><?php echo $stock_info['product_name']?></div>
                                    <?php
                                    }
                                    ?>
                                </div>
                                <div class="span1">
                                    <h3>Product Code</h3>
                                    <?php foreach($stock_list as $key => $stock_info)
                                    {
                                    ?>
                                    <div class="wh_100"><?php echo $stock_info['product_code']?></div>
                                    <?php
                                    }
                                    ?>
                                </div>
                                <div class="span1">
                                    <h3>Quantity</h3>
                                    <?php foreach($stock_list as $key => $stock_info)
                                    {
                                    ?>
                                    <div class="wh_100"><?php echo $stock_info['stock_amount']?></div>
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
