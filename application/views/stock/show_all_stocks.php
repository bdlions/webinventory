<div class ="row">
    <div class="form-background col-md-11">
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Shop Name</th>
                        <th>Product Name</th>
                        <th>Lot No</th>
                        <th>Quantity</th>
                    </tr>
                </thead>
                <tbody id="tbody_product_list">
                    <?php
                    foreach ($stock_list as $key => $stock_info) {
                    ?>
                        <tr>
                            <td><?php echo $stock_info['shop_name'] ?></td>
                            <td><?php echo $stock_info['product_name'] ?></td>
                            <td><?php echo $stock_info['purchase_order_no'] ?></td>
                            <td><?php echo $stock_info['stock_amount'] ?></td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div> 
</div>