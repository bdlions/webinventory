<h3>Customer Transactions</h3>
<div class ="form-horizontal form-background top-bottom-padding">          
    <div class="table-responsive">
        <div class="row" style="margin:0px;">
            <div class="col-md-3 col-lg-offset-1">
                <div class="row">
                    <div class="form-group">
                        <label for="" class="col-md-6 control-label">
                            Customer Name
                        </label>
                        <label for="" class="col-md-6 control-label">
                            <?php echo $customer_info['first_name'].' '.$customer_info['last_name']; ?>
                        </label>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group">
                        <label for="first_name" class="col-md-6 control-label">
                            Mobile Number
                        </label>
                        <label for="first_name" class="col-md-6 control-label">
                            <?php echo $customer_info['phone']; ?>
                        </label>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group">
                        <label for="first_name" class="col-md-6 control-label">
                            Card No
                        </label>
                        <label for="first_name" class="col-md-6 control-label">
                            <?php echo $customer_info['card_no']; ?>
                        </label>
                    </div>
                </div>
            </div>
            <div class="col-md-offset-1 col-md-4"> 
            <div class="row">
                    <div class="form-group">
                        <label for="" class="col-md-6 control-label">
                            Total Purchased Quantity
                        </label>
                        <label for="" class="col-md-6 control-label">
                            25
                        </label>
                    </div>
                </div>
            <div class="row">
                    <div class="form-group">
                        <label for="" class="col-md-6 control-label">
                            Total Purchased Price
                        </label>
                        <label for="" class="col-md-6 control-label">
                            2500
                        </label>
                    </div>
                </div>
            <div class="row">
                    <div class="form-group">
                        <label for="" class="col-md-6 control-label">
                            Total Profit
                        </label>
                        <label for="" class="col-md-6 control-label">
                            1000
                        </label>
                    </div>
                </div>
            </div>
        </div>
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
                    <th>Remarks</th>
                </tr>
            </thead>
            <tbody id="tbody_product_list">
                <?php
                $i=0;
                $length = count($customer_transaction_list);
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
                        <td><?php if($i+1<$length && $customer_transaction_list[$i]['remarks']!='' && $customer_transaction_list[$i+1]['remarks']==''){echo $customer_transaction['remarks'];} ?></td>
                    </tr>
                <?php
                    $i++;
                }
                ?>
            </tbody>
        </table>
    </div>   
</div>