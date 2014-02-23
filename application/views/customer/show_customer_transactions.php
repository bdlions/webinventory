<div class ="row">
    <div class="form-background col-md-11">
        <div class="row">
            <div class="col-md-3">
                <div class="row">
                    <div class="form-group">
                        <label for="first_name" class="col-md-6 control-label">
                            Customer Name
                        </label>
                        <div class ="col-md-6">
                            <?php echo $customer_info['first_name'].' '.$customer_info['last_name']; ?>
                        </div> 
                    </div>
                </div>
                <div class="row">
                    <div class="form-group">
                        <label for="first_name" class="col-md-6 control-label">
                            Mobile Number
                        </label>
                        <div class ="col-md-6">
                            <?php echo $customer_info['phone']; ?>
                        </div> 
                    </div>
                </div>
                <div class="row">
                    <div class="form-group">
                        <label for="first_name" class="col-md-6 control-label">
                            Card No
                        </label>
                        <div class ="col-md-6">
                            <?php echo $customer_info['card_no']; ?>
                        </div> 
                    </div>
                </div>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Lot No</th>
                        <th>Product Name</th>
                        <th>Quantity</th>
                        <th>Purchase Unit Price</th>
                        <th>Sub Total</th>
                        <th>Payment Status</th>
                    </tr>
                </thead>
                <tbody id="tbody_product_list">
                    <?php
                    foreach ($customer_transaction_list as $key => $customer_transaction) {
                    ?>
                        <tr>
                            <td><?php echo $customer_transaction['created_on'] ?></td>
                            <td><?php echo $customer_transaction['lot_no'] ?></td>
                            <td><?php echo $customer_transaction['name'] ?></td>
                            <td><?php echo $customer_transaction['quantity'] ?></td>
                            <td><?php echo $customer_transaction['unit_price'] ?></td>
                            <td><?php echo $customer_transaction['sub_total'] ?></td>
                            <td><?php echo $customer_transaction['payment_status'] ?></td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div> 
</div>