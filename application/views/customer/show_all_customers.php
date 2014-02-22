<div class ="row">
    <div class="form-background col-md-11">
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Phone</th>
                        <th>Address</th>
                        <th>Card No</th>
                        <th>Manage</th>
                        <th>Show</th>
                    </tr>
                </thead>
                <tbody id="tbody_product_list">
                    <?php
                    foreach ($customer_list as $key => $customer_info) {
                    ?>
                        <tr>
                            <td><?php echo $customer_info['first_name'] ?></td>
                            <td><?php echo $customer_info['last_name'] ?></td>
                            <td><?php echo $customer_info['phone'] ?></td>
                            <td><?php echo $customer_info['address'] ?></td>
                            <td><?php echo $customer_info['card_no'] ?></td>
                            <td><a href="<?php echo base_url("./user/update_customer/" . $customer_info['user_id']); ?>">Update</a></td>
                            <td><a href="<?php echo base_url("./user/show_customer/" . $customer_info['user_id']); ?>">Show</a></td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div> 
</div>