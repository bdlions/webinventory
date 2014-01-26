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
                Company
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
        foreach ($supplier_list as $key => $supplier_info) {
            ?>
            <div class="row">
                <div class="col-md-10">
                    <div class ="col-md-1">
                        <?php echo $supplier_info['first_name'] ?>
                    </div>
                    <div class ="col-md-1">
                        <?php echo $supplier_info['last_name'] ?>
                    </div>
                    <div class ="col-md-1">
                        <?php echo $supplier_info['phone'] ?>
                    </div>
                    <div class ="col-md-1">
                        <?php echo $supplier_info['address'] ?>
                    </div>
                    <div class ="col-md-1">
                        <?php echo $supplier_info['company'] ?>
                    </div>
                    <div class ="col-md-1">
                        <a href="<?php echo base_url("./user/update_supplier/" . $supplier_info['user_id']); ?>">Update</a>
                    </div>
                    <div class ="col-md-1">
                        <a href="<?php echo base_url("./user/show_supplier/" . $supplier_info['user_id']); ?>">Show</a>
                    </div>
                </div>
            </div>
            <?php
        }
        ?>
    </div>
</div>