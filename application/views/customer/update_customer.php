<div class ="row">
    <div class ="col-md-12">
        <div class ="row">
            <div class ="col-md-12 form-horizontal form-background">
                <?php echo form_open("user/update_customer/".$customer_info['user_id'], array('id' => 'form_update_customer', 'class' => 'form-horizontal')); ?>
                <div class="row">
                    <div class ="col-md-5 col-md-offset-2 margin-top-bottom">
                        <div class ="row">
                            <div class="col-md-4"></div>
                            <div class="col-md-8"><?php echo $message; ?></div>
                        </div>
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
                                Card No
                            </label>
                            <div class ="col-md-6">
                                <?php echo form_input($card_no+array('class'=>'form-control')); ?>
                            </div> 
                        </div>
                        <div class="form-group">
                            <label for="address" class="col-md-6 control-label requiredField">
                                Institution
                            </label>
                            <div class ="col-md-6">
                                <?php echo form_dropdown('institution_list', $institution_list, $selected_institution,'class=form-control'); ?>
                            </div> 
                        </div>
                        <div class="form-group">
                            <label for="address" class="col-md-6 control-label requiredField">
                                Profession
                            </label>
                            <div class ="col-md-6">
                                <?php echo form_dropdown('profession_list', $profession_list, $selected_profession, 'class=form-control'); ?>
                            </div> 
                        </div>
                        <div class="form-group">
                            <label for="address" class="col-md-6 control-label requiredField">

                            </label>
                            <div class ="col-md-6">
                                <?php echo form_input($submit_update_customer+array('class'=>'form-control btn-success')); ?>
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