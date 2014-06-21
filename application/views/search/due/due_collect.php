<h3>Due Collect List</h3>
<div class ="form-background top-bottom-padding">
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Time & Date</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <?php if($shop_info['shop_type_id']==SHOP_TYPE_SMALL):?><th>Card No</th><?php endif;?>
                    <th>Amount</th>
                </tr>
            </thead>
            <tbody id="tbody_product_list">
                <?php
                foreach ($due_collect_list as $due_collect) {
                ?>
                    <tr>
                        <td><?php echo $due_collect['created_on'] ?></td>
                        <td><?php echo $due_collect['first_name'] ?></td>
                        <td><?php echo $due_collect['last_name'] ?></td>  
                        <?php if($shop_info['shop_type_id']==SHOP_TYPE_SMALL):?><td><?php echo $due_collect['card_no'] ?></td><?php endif;?>     
                        <td><?php echo $due_collect['amount'] ?></td>                        
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    </div>
</div>