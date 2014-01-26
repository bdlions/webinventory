<div class ="row form-background">
    <div class ="row">
        <div class="col-md-10">
            <div class ="col-md-2">
                First Name
            </div>
            <div class ="col-md-2">
                Last Name
            </div>
            <div class ="col-md-2">
                Phone
            </div>
            <div class ="col-md-2">
                Address
            </div>
            <div class ="col-md-2">
                Manage
            </div>
        </div>
    </div>
    <div class="row">
        <?php
        foreach ($salesman_list as $key => $salesman_info) {
            ?>
            <div class="row">
                <div class="col-md-10">
                    <div class ="col-md-2">
                        <?php echo $salesman_info['first_name'] ?>
                    </div>
                    <div class ="col-md-2">
                        <?php echo $salesman_info['last_name'] ?>
                    </div>
                    <div class ="col-md-2">
                        <?php echo $salesman_info['phone'] ?>
                    </div>
                    <div class ="col-md-2">
                        <?php echo $salesman_info['address'] ?>
                    </div>
                    <div class ="col-md-1">
                        <a href="<?php echo base_url("./user/update_salesman/" . $salesman_info['user_id']); ?>">Update</a>
                    </div>
                </div>
            </div>
            <?php
        }
        ?>
    </div>
</div>