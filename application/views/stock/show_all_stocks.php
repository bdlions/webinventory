<div class ="row form-background">
    <div class ="row">
        <div class="col-md-10">
            <div class ="col-md-1">
                Shop Name
            </div>
            <div class ="col-md-1">
                Product Name
            </div>
            <div class ="col-md-1">
                Lot No
            </div>
            <div class ="col-md-1">
                Quantity
            </div>
        </div>
    </div>
    <div class="row">
        <?php
        foreach ($stock_list as $key => $stock_info) {
            ?>
            <div class="row">
                <div class="col-md-10">
                    <div class ="col-md-1">
                        <?php echo $stock_info['shop_name'] ?>
                    </div>
                    <div class ="col-md-1">
                        <?php echo $stock_info['product_name'] ?>
                    </div>
                    <div class ="col-md-1">
                        <?php echo $stock_info['purchase_order_no'] ?>
                    </div>
                    <div class ="col-md-1">
                        <?php echo $stock_info['stock_amount'] ?>
                    </div>
                </div>
            </div>
            <?php
        }
        ?>
    </div>
</div>