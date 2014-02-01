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
                                Browse
                            </label>
                            <div class ="col-md-6">
                                <input class="form-control" type="file" name="userfile"/>
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