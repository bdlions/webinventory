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
        foreach ($manager_list as $key => $manager_info) {
            ?>
            <div class="row">
                <div class="col-md-10">
                    <div class ="col-md-2">
                        <?php echo $manager_info['first_name'] ?>
                    </div>
                    <div class ="col-md-2">
                        <?php echo $manager_info['last_name'] ?>
                    </div>
                    <div class ="col-md-2">
                        <?php echo $manager_info['phone'] ?>
                    </div>
                    <div class ="col-md-2">
                        <?php echo $manager_info['address'] ?>
                    </div>
                    <div class ="col-md-1">
                        <a href="<?php echo base_url("./user/update_manager/" . $manager_info['user_id']); ?>">Update</a>
                    </div>
                </div>
            </div>
            <?php
        }
        ?>
    </div>
</div>