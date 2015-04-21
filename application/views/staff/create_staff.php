<h3>Create Staff</h3>
<div class ="form-horizontal form-background top-bottom-padding">
    <?php echo form_open("staff/create_staff", array('id' => 'form_create_staff', 'class' => 'form-horizontal')); ?>
    <div class="row">
        <div class ="col-md-5">
            <div class ="row">
                <div class="col-md-4"></div>
                <div class="col-md-8"><?php echo $message; ?></div>
            </div>
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
                <label for="username" class="col-md-6 control-label requiredField">
                    User Name
                </label>
                <div class ="col-md-6">
                    <?php echo form_input($username+array('class'=>'form-control')); ?>
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
        </div>
        <div class ="col-md-5">
            <div class="form-group">
                <label for="country_code" class="col-md-6 control-label requiredField">
                    Phone Country Code
                </label>
                <div class ="col-md-6">
                    <?php echo form_input($country_code+array('class'=>'form-control')); ?>
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
                <label for="staff_email" class="col-md-6 control-label requiredField">
                    Email
                </label>
                <div class ="col-md-6">
                    <?php echo form_input($staff_email+array('class'=>'form-control')); ?>
                </div> 
            </div>
            <div class="form-group">
                <label for="staff_password" class="col-md-6 control-label requiredField">
                    Password
                </label>
                <div class ="col-md-6">
                    <?php echo form_input($staff_password+array('class'=>'form-control')); ?>
                </div> 
            </div>
            <div class="form-group">
                <label for="staff_password_confirm" class="col-md-6 control-label requiredField">
                    Confirm Password
                </label>
                <div class ="col-md-6">
                    <?php echo form_input($staff_password_confirm+array('class'=>'form-control')); ?>
                </div> 
            </div>
            <div class="form-group">
                <label for="address" class="col-md-6 control-label requiredField">

                </label>
                <div class ="col-md-3 col-md-offset-3">
                    <?php echo form_input($submit_create_staff+array('class'=>'form-control btn-success')); ?>
                </div> 
            </div>
        </div>
    </div>
    <?php echo form_close(); ?>
</div>