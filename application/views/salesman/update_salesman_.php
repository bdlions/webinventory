<h3>Update Equipment Supplier</h3>
<div class ="form-horizontal form-background top-bottom-padding">
    <div class="row">
        <div class ="col-md-5 margin-top-bottom">
    <?php echo form_open("user/update_salesman/".$salesman_info['id'], array('id' => 'form_update_salesman', 'class' => 'form-horizontal')); ?>
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
            <?php echo form_close(); ?>
        </div>
        <div class="col-md-5">
            <?php echo form_open("user/update_salesman_password/".$salesman_info['id'], array('id' => 'form_update_salesman_password', 'class' => 'form-horizontal')); ?>
            <div class="form-group">
                <label for="password" class="col-md-6 control-label requiredField">
                   Old Password
                </label>
                <div class ="col-md-6">
                    <?php echo form_input($old_password+array('class'=>'form-control')); ?>
                </div> 
            </div>
            <div class="form-group">
                <label for="password_confirm" class="col-md-6 control-label requiredField">
                    New Password
                </label>
                <div class ="col-md-6">
                    <?php echo form_input($new_password+array('class'=>'form-control')); ?>
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

                </label>
                <div class ="col-md-3 col-md-offset-3">
                    <?php echo form_input($submit_update_salesman+array('class'=>'form-control btn-success')); ?>
                </div> 
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>