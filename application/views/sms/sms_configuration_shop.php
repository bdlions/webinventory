<div class ="row">
    <div class ="col-md-12">
        <div class ="row">
            <div class ="col-md-12 form-horizontal form-background">
                <?php echo form_open("sms/sms_configuration_shop", array('id' => 'form_sms_configuration_shop', 'class' => 'form-horizontal')); ?>
                <div class="row">
                    <div class ="col-md-5 col-md-offset-2 margin-top-bottom">
                        <div class ="row">
                            <div class="col-md-4"></div>
                            <div class="col-md-8"><?php echo $message; ?></div>
                        </div>
                        <?php echo form_fieldset(''); ?>
                        <div class="form-group">
                            <label for="phone" class="col-md-6 control-label requiredField">
                                Select Shop
                            </label>
                            <div class ="col-md-6">
                                <?php echo form_dropdown('shop_list', array(''=>'Select Shop')+$shop_list, '', 'class=form-control'); ?>
                            </div> 
                        </div>
                        <div class="form-group">
                            <label for="phone" class="col-md-6 control-label requiredField">
                                SMS Status
                            </label>
                            <div class ="col-md-6">
                                <input type="hidden" name="sms_configuration_shop_status" value="0" />
                                <?php echo form_checkbox($sms_configuration_shop_status+array('class'=>'form-control')); ?>
                            </div> 
                        </div>
                        <div class="form-group">
                            <label for="address" class="col-md-6 control-label requiredField">

                            </label>
                            <div class ="col-md-6">
                                <?php echo form_input($submit_sms_configuration_shop+array('class'=>'form-control btn-success')); ?>
                            </div> 
                        </div>
                        <?php echo form_fieldset_close(); ?>
                    </div>
                </div>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>    
</div>