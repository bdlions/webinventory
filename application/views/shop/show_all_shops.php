<div class ="row form-background">
    <div class ="row">
        <div class="col-md-10">
            <div class ="col-md-2">
                Shop No
            </div>
            <div class ="col-md-2">
                Shop Name
            </div>
            <div class ="col-md-2">
                Shop Phone
            </div>
            <div class ="col-md-2">
                Shop Address
            </div>
            <div class ="col-md-2">
                Manage
            </div>
        </div>
    </div>
    <div class="row">
        <?php foreach($shop_list as $key => $shop_info)
        {
        ?>
        <div class="row">
            <div class="col-md-10">
                <div class ="col-md-2">
                    <?php echo $shop_info['shop_no']?>
                </div>
                <div class ="col-md-2">
                    <?php echo $shop_info['name']?>
                </div>
                <div class ="col-md-2">
                    <?php echo $shop_info['shop_phone']?>
                </div>
                <div class ="col-md-2">
                    <?php echo $shop_info['address']?>
                </div>
                <div class ="col-md-2">
                    <a href="<?php echo base_url("./shop/update_shop/".$shop_info['id']);?>">Update</a>
                </div>
            </div>
        </div>
        <?php
        }
        ?>
    </div>
</div>