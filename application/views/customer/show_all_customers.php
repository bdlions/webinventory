<div class ="row form-background">
    <div class ="row">
        <div class="col-md-10">
            <div class ="col-md-1">
                First Name
            </div>
            <div class ="col-md-1">
                Last Name
            </div>
            <div class ="col-md-1">
                Phone
            </div>
            <div class ="col-md-1">
                Address
            </div>
            <div class ="col-md-1">
                Card No 
            </div>
            <div class ="col-md-1">
                Manage
            </div>
            <div class ="col-md-1">
                Show
            </div>
        </div>
    </div>
    <div class="row">
        <?php
        foreach ($customer_list as $key => $customer_info) {
            ?>
            <div class="row">
                <div class="col-md-10">
                    <div class ="col-md-1">
                        <?php echo $customer_info['first_name'] ?>
                    </div>
                    <div class ="col-md-1">
                        <?php echo $customer_info['last_name'] ?>
                    </div>
                    <div class ="col-md-1">
                        <?php echo $customer_info['phone'] ?>
                    </div>
                    <div class ="col-md-1">
                        <?php echo $customer_info['address'] ?>
                    </div>
                    <div class ="col-md-1">
                        <?php echo $customer_info['card_no'] ?>
                    </div>
                    <div class ="col-md-1">
                        <a href="<?php echo base_url("./user/update_customer/" . $customer_info['user_id']); ?>">Update</a>
                    </div>
                    <div class ="col-md-1">
                        <a href="<?php echo base_url("./user/show_customer/" . $customer_info['user_id']); ?>">Show</a>
                    </div>
                </div>
            </div>
            <?php
        }
        ?>
    </div>
</div>