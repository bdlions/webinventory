<h3>Supplier returned payment list</h3>
<div class ="form-background top-bottom-padding">
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Time & Date</th>
                    <th>Supplier Name</th>
                    <th>Lot No</th>
                    <th>Amount</th>
                </tr>
            </thead>
            <tbody id="tbody_product_list">
                <?php
                foreach ($suppliers_returned_payment_list as $supplier_returned_payment_list) {
                ?>
                    <tr>
                        <td><?php echo $supplier_returned_payment_list['created_on'] ?></td>
                        <td><?php echo $supplier_returned_payment_list['first_name'].' '.$supplier_returned_payment_list['last_name'] ?></td>
                        <td><?php echo $supplier_returned_payment_list['purchase_order_no'] ?></td>     
                        <td><?php echo $supplier_returned_payment_list['amount'] ?></td>                        
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    </div>
</div>