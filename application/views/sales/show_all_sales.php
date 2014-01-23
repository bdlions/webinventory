<h2>Sale Details</h2>
<div class="clr search_details">
    <div class="clr span12">
        <div class="span12">
            <div class="row-fluid">
                <div class="tabbable">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#tabs1-pane1" data-toggle="tab">Sale List</a></li>								
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="tabs1-pane1">
                            <p class="clr">
                            <div class="clr product_details sales_order_details specific span10">
                                <div style="width:3%;" class="blank_div span0">
                                    <h3 class="" style="background-image:none;">&nbsp;</h3>
                                    <?php foreach($sale_list as $key => $sale_info)
                                    {
                                    ?>
                                    <div class="wh_100"><p class="wh_100">&nbsp;</p></div>
                                    <?php
                                    }
                                    ?>
                                </div>
                                <div class="span1">
                                    <h3>Product Name</h3>
                                    <?php foreach($sale_list as $key => $sale_info)
                                    {
                                    ?>
                                    <div class="wh_100"><?php echo $sale_info['name']?></div>
                                    <?php
                                    }
                                    ?>
                                </div>
                                <div class="span1">
                                    <h3>Lot No</h3>
                                    <?php foreach($sale_list as $key => $sale_info)
                                    {
                                    ?>
                                    <div class="wh_100"><?php echo $sale_info['purchase_order_no']?></div>
                                    <?php
                                    }
                                    ?>
                                </div>
                                <div class="span1">
                                    <h3>Quantity</h3>
                                    <?php foreach($sale_list as $key => $sale_info)
                                    {
                                    ?>
                                    <div class="wh_100"><?php echo $sale_info['quantity']?></div>
                                    <?php
                                    }
                                    ?>
                                </div>
                                <div class="span1">
                                    <h3>Purchase Unit Price</h3>
                                    <?php foreach($sale_list as $key => $sale_info)
                                    {
                                    ?>
                                    <div class="wh_100"><?php echo $sale_info['purchase_unit_price']?></div>
                                    <?php
                                    }
                                    ?>
                                </div>
                                <div class="span1">
                                    <h3>Sale Unit Price</h3>
                                    <?php foreach($sale_list as $key => $sale_info)
                                    {
                                    ?>
                                    <div class="wh_100"><?php echo $sale_info['sale_unit_price']?></div>
                                    <?php
                                    }
                                    ?>
                                </div>
                                <div class="span1">
                                    <h3>Total Purchase Price</h3>
                                    <?php foreach($sale_list as $key => $sale_info)
                                    {
                                    ?>
                                    <div class="wh_100"><?php echo $sale_info['quantity']*$sale_info['purchase_unit_price'] ?></div>
                                    <?php
                                    }
                                    ?>
                                </div>
                                <div class="span1">
                                    <h3>Discount(%)</h3>
                                    <?php foreach($sale_list as $key => $sale_info)
                                    {
                                    ?>
                                    <div class="wh_100"><?php echo $sale_info['discount']?></div>
                                    <?php
                                    }
                                    ?>
                                </div>
                                <div class="span1">
                                    <h3>Total Sale Price</h3>
                                    <?php foreach($sale_list as $key => $sale_info)
                                    {
                                    ?>
                                    <div class="wh_100"><?php echo $sale_info['total_sale_price']?></div>
                                    <?php
                                    }
                                    ?>
                                </div>                                
                                <div class="span1">
                                    <h3>Net Profit</h3>
                                    <?php foreach($sale_list as $key => $sale_info)
                                    {
                                    ?>
                                    <div class="wh_100"><?php echo ($sale_info['total_sale_price'] - ($sale_info['quantity']*$sale_info['purchase_unit_price'])) ?></div>
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
