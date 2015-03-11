<h3>Update Shop</h3>
<div class ="form-horizontal form-background top-bottom-padding">
    <?php echo form_open("shop/update_shop/".$shop_info['id'], array('id' => 'form_update_shop', 'class' => 'form-horizontal')); ?>
    <div class="row">
        <div class ="col-md-5 col-md-offset-2 margin-top-bottom">
            <div class ="row">
                <div class="col-md-4"></div>
                <div class="col-md-8"><?php echo $message; ?></div>
            </div>
            <div class="form-group">
                <label for="first_name" class="col-md-6 control-label requiredField">
                    Shop Name *
                </label>
                <div class ="col-md-6">
                    <?php echo form_input($shop_name+array('class'=>'form-control')); ?>
                </div> 
            </div>
            <div class="form-group">
                <label for="last_name" class="col-md-6 control-label requiredField">
                    Shop Phone
                </label>
                <div class ="col-md-6">
                    <?php echo form_input($shop_phone+array('class'=>'form-control')); ?>
                </div> 
            </div>
            <div class="form-group">
                <label for="address" class="col-md-6 control-label requiredField">
                    Shop Address *
                </label>
                <div class ="col-md-6">
                    <?php echo form_input($shop_address+array('class'=>'form-control')); ?>
                </div> 
            </div>
            <div class="form-group">
                <label for="purchase_default_purchase_order_no" class="col-md-6 control-label requiredField">
                    Default Purchase Lot No
                </label>
                <div class ="col-md-6">
                    <?php echo form_input($purchase_default_purchase_order_no+array('class'=>'form-control')); ?>
                </div> 
            </div>
            <div class="form-group">
                <label for="sale_default_purchase_order_no" class="col-md-6 control-label requiredField">
                   Default Sale Lot No
                </label>
                <div class ="col-md-6">
                    <?php echo form_input($sale_default_purchase_order_no+array('class'=>'form-control')); ?>
                </div> 
            </div>
            <div class="form-group">
                <label for="address" class="col-md-6 control-label requiredField">

                </label>
                <div class ="col-md-3 col-md-offset-3">
                    <?php echo form_input($submit_update_shop+array('class'=>'form-control btn-success')); ?>
                </div> 
            </div>
        </div>
    </div>
    <?php echo form_close(); ?>
</div>