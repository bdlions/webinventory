<h3>Customer returned payment list</h3>
<div class ="form-background top-bottom-padding">
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Time & Date</th>
                    <th>Customer Name</th>
                    <?php if($shop_info['shop_type_id']==SHOP_TYPE_SMALL):?>
                        <th>Card No</th>
                    <?php endif;?>
                    <th>Amount</th>
                </tr>
            </thead>
            <tbody id="tbody_product_list">
                <?php
                foreach ($customers_returned_payment_list as $customer_returned_payment_list) {
                ?>
                    <tr>
                        <td><?php echo $customer_returned_payment_list['created_on'] ?></td>
                        <td><?php echo $customer_returned_payment_list['first_name'].' '.$customer_returned_payment_list['last_name'] ?></td>
                        <?php if($shop_info['shop_type_id']==SHOP_TYPE_SMALL):?>
                            <td><?php echo $customer_returned_payment_list['card_no'] ?></td>
                        <?php endif;?>     
                        <td><?php echo $customer_returned_payment_list['amount'] ?></td>                        
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    </div>
</div>