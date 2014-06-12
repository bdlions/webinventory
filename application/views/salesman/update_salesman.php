<h3>Update Staff</h3>
<div class ="form-horizontal form-background top-bottom-padding">
    <?php echo form_open("user/update_salesman/".$salesman_info['id'], array('id' => 'form_update_salesman', 'class' => 'form-horizontal')); ?>
    <div class="row">
        <div class ="col-md-5 col-md-offset-2 margin-top-bottom">
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
                <label for="phone" class="col-md-6 control-label requiredField">
                    Phone No
                </label>
                <div class ="col-md-6">
                    <?php echo form_input($phone+array('class'=>'form-control')); ?>
                </div> 
            </div>
            <div class="form-group">
                <label for="password" class="col-md-6 control-label requiredField">
                    Password
                </label>
                <div class ="col-md-6">
                    <?php echo form_input($password+array('class'=>'form-control')); ?>
                </div> 
            </div>
            <div class="form-group">
                <label for="password_confirm" class="col-md-6 control-label requiredField">
                    Confirm Password
                </label>
                <div class ="col-md-6">
                    <?php echo form_input($password_confirm+array('class'=>'form-control')); ?>
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
                <label for="address" class="col-md-6 control-label requiredField">

                </label>
                <div class ="col-md-3 col-md-offset-3">
                    <?php echo form_input($submit_update_salesman+array('class'=>'form-control btn-success')); ?>
                </div> 
            </div>
        </div>
    </div>
    <?php echo form_close(); ?>
</div>