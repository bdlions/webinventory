<div class ="row">
    <div class ="col-md-12">
        <div class ="row">
            <div class ="col-md-12 form-horizontal form-background">
                <div class="row">
                    <div class ="col-md-5 col-md-offset-2 margin-top-bottom">
                        <?php echo form_fieldset('General Information'); ?>
                        <div class="form-group">
                            <label for="first_name" class="col-md-6 control-label requiredField">
                                First Name
                            </label>
                            <div class ="col-md-6">
                                <?php echo form_input($first_name+array('class'=>'form-control')); ?>
                            </div> 
                        </div>
                        <div class="form-group">
                            <label for="last_name" class="col-md-6 control-label requiredField">
                                Last Name
                            </label>
                            <div class ="col-md-6">
                                <?php echo form_input($last_name+array('class'=>'form-control')); ?>
                            </div> 
                        </div>
                        <div class="form-group">
                            <label for="phone" class="col-md-6 control-label requiredField">
                                Phone No
                            </label>
                            <div class ="col-md-6">
                                <?php echo form_input($phone+array('class'=>'form-control')); ?>
                            </div> 
                        </div>
                        <div class="form-group">
                            <label for="address" class="col-md-6 control-label requiredField">
                                Address
                            </label>
                            <div class ="col-md-6">
                                <?php echo form_input($address+array('class'=>'form-control')); ?>
                            </div> 
                        </div>
                        <div class="form-group">
                            <label for="card_no" class="col-md-6 control-label requiredField">
                                Company
                            </label>
                            <div class ="col-md-6">
                                <?php echo form_input($company+array('class'=>'form-control')); ?>
                            </div> 
                        </div>                        
                        <?php echo form_fieldset_close(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>    
</div>