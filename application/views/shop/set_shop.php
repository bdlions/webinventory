<h3>Change Shop</h3>
<div class ="form-horizontal form-background top-bottom-padding">
    <?php echo form_open("shop/set_shop", array('id' => 'form_set_shop', 'class' => 'form-horizontal')); ?>
    <div class="row">
        <div class ="col-md-5 col-md-offset-2 margin-top-bottom">
            <div class ="row">
                <div class="col-md-4"></div>
                <div class="col-md-8"><?php echo $message; ?></div>
            </div>
            <div class="form-group">
                <label for="phone" class="col-md-6 control-label requiredField">
                    Select Shop
                </label>
                <div class ="col-md-6">
                    <?php echo form_dropdown('shop_list', $shop_list, $select_shop_id, 'class=form-control'); ?>
                </div> 
            </div>
            <div class="form-group">
                <label for="address" class="col-md-6 control-label requiredField">

                </label>
                <div class ="col-md-3 col-md-offset-3">
                    <?php echo form_input($submit_set_shop+array('class'=>'form-control btn-success')); ?>
                </div> 
            </div>
        </div>
    </div>
    <?php echo form_close(); ?>
</div>