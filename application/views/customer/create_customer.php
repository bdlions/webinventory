<h2>Create Customer</h2>
<div class ="row">
    <div class ="col-md-12">
        <div class ="row">
            <ul>
                <li ><a href="#tabs1-pane1" data-toggle="tab">Customer Info</a></li>								
            </ul>
        </div>
        <div class ="row boxshad">
            <div class ="col-md-12 form-horizontal">
                <div class ="row">
                    <?php echo form_open("user/create_customer", array('id' => 'form_create_customer', 'class' => 'form-horizontal')); ?>
                </div>
                <div class ="row">
                    <?php echo $message; ?>
                </div>
                <div class="row">
                    <div class ="col-md-4">
                        <?php echo form_fieldset('General Information'); ?>
                        <div class="form-group">
                            <label for="phone" class="col-md-3 control-label requiredField">
                                Phone No.
                            </label>
                            <div class ="col-md-8">
                                <?php echo form_input($phone); ?>
                            </div> 
                        </div>
                        <div class="form-group">
                            <label for="first_name" class="col-md-3 control-label requiredField">
                                First Name
                            </label>
                            <div class ="col-md-8">
                                <?php echo form_input($first_name); ?>
                            </div> 
                        </div>
                        <div class="form-group">
                            <label for="last_name" class="col-md-3 control-label requiredField">
                                Last Name
                            </label>
                            <div class ="col-md-8">
                                <?php echo form_input($last_name); ?>
                            </div> 
                        </div>
                        <div class="form-group">
                            <label for="address" class="col-md-3 control-label requiredField">
                                Address
                            </label>
                            <div class ="col-md-8">
                                <?php echo form_input($address); ?>
                            </div> 
                        </div>
                        <?php echo form_fieldset_close(); ?>
                    </div>
                    <div class ="col-md-4">
                        <?php echo form_fieldset('Picture'); ?>
                        <div class="form-group">
                            <label for="picture" class="col-md-4 control-label requiredField">
                                Upload Picture
                            </label>
                            <div class ="col-md-6">
                                <?php echo form_input(array('name' => 'picture', 'type' => 'file', 'id' => 'customer-picture')); ?>
                            </div> 
                        </div>														
                        <?php echo form_fieldset_close(); ?>
                    </div>

                </div>
                <div class ="row">
                    <div class ="col-md-4">
                        <?php echo form_fieldset('Customer Information'); ?>
                        <div class="form-group">
                            <label for="card_no" class="col-md-3 control-label requiredField">
                                Card No.
                            </label>
                            <div class ="col-md-8">
                                <?php echo form_input($card_no); ?>
                            </div> 
                        </div>
                        <div class="form-group">
                            <label for="last_name" class="col-md-3 control-label requiredField">
                                Institution
                            </label>
                            <div class ="col-md-8">
                                <?php echo form_dropdown('institution_list', $institution_list, array(' "class" => "form-control"')); ?> 
                            </div> 
                        </div>
                        <div class="form-group">
                            <label for="address" class="col-md-3 control-label requiredField">
                                Profession
                            </label>
                            <div class ="col-md-8">
                                <?php echo form_dropdown('profession_list', $profession_list); ?> 
                            </div> 
                        </div>
                        <div class="form-group">
                            <label for="address" class="col-md-3 control-label requiredField">

                            </label>
                            <div class ="col-md-8">
                                <?php echo form_input($submit_create_customer); ?>
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
