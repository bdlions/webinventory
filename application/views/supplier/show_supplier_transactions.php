<h3>Supplier Transactions</h3>
<div class ="form-horizontal form-background top-bottom-padding">    
    <div class="table-responsive">
        <div class="row" style="margin:0px;">
            <div class="col-md-3 col-lg-offset-1">
                <div class="row">
                    <div class="form-group">
                        <label for="first_name" class="col-md-4 control-label">
                            Supplier Name
                        </label>
                        <label for="first_name" class="col-md-4 control-label">
                            <?php echo $supplier_info['first_name'].' '.$supplier_info['last_name']; ?>
                        </label>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group">
                        <label for="first_name" class="col-md-4 control-label">
                            Mobile Number
                        </label>
                        <label for="first_name" class="col-md-4 control-label">
                            <?php echo $supplier_info['phone']; ?>
                        </label>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group">
                        <label for="first_name" class="col-md-4 control-label">
                            Company
                        </label>
                        <label for="first_name" class="col-md-4 control-label">
                            Company
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
                $length = count($supplier_transaction_list);$i=0;
                foreach ($supplier_transaction_list as $key => $supplier_transaction) {
                ?>
                    <tr>
                        <td><?php echo $supplier_transaction['created_on'] ?></td>
                        <td><?php echo $supplier_transaction['lot_no'] ?></td>
                        <td><?php echo $supplier_transaction['name'] ?></td>
                        <td><?php echo $supplier_transaction['quantity'] ?></td>
                        <td><?php echo $supplier_transaction['unit_price'] ?></td>
                        <td><?php echo $supplier_transaction['sub_total'] ?></td>
                        <td><?php echo $supplier_transaction['payment_status'] ?></td>
                        <td><?php echo $supplier_transaction['remarks'] ?></td>
                    </tr>
                <?php
                    $i++;
                }
                ?>
            </tbody>
        </table>
    </div>     
</div>