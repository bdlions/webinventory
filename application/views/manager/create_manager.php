<h3><?php echo $this->lang->line("user_create_manager_header"); ?></h3>
<div class ="form-horizontal form-background top-bottom-padding">
    <?php echo form_open("user/create_manager", array('id' => 'form_create_manager', 'class' => 'form-horizontal')); ?>
    <div class="row">
        <div class ="col-md-5 col-md-offset-2 margin-top-bottom">
            <div class ="row">
                <div class="col-md-4"></div>
                <div class="col-md-8"><?php echo $message; ?></div>
            </div>
            <div class="form-group">
                <label for="first_name" class="col-md-6 control-label requiredField">
                    <?php echo $this->lang->line("user_create_manager_first_name"); ?>
                </label>
                <div class ="col-md-6">
                    <?php echo form_input($first_name+array('class'=>'form-control')); ?>
                </div> 
            </div>
            <div class="form-group">
                <label for="last_name" class="col-md-6 control-label requiredField">
                    <?php echo $this->lang->line("user_create_manager_last_name"); ?>
                </label>
                <div class ="col-md-6">
                    <?php echo form_input($last_name+array('class'=>'form-control')); ?>
                </div> 
            </div>
            <div class="form-group">
                <label for="username" class="col-md-6 control-label requiredField">
                    <?php echo $this->lang->line("user_create_manager_user_name"); ?>
                </label>
                <div class ="col-md-6">
                    <?php echo form_input($username+array('class'=>'form-control')); ?>
                </div> 
            </div>
            <div class="form-group">
                <label for="email" class="col-md-6 control-label requiredField">
                    <?php echo $this->lang->line("user_create_manager_email"); ?>
                </label>
                <div class ="col-md-6">
                    <?php echo form_input($email+array('class'=>'form-control')); ?>
                </div> 
            </div>
            <div class="form-group">
                <label for="password" class="col-md-6 control-label requiredField">
                    <?php echo $this->lang->line("user_create_manager_password"); ?>
                </label>
                <div class ="col-md-6">
                    <?php echo form_input($password+array('class'=>'form-control')); ?>
                </div> 
            </div>
            <div class="form-group">
                <label for="password_confirm" class="col-md-6 control-label requiredField">
                    <?php echo $this->lang->line("user_create_manager_confirm_password"); ?>
                </label>
                <div class ="col-md-6">
                    <?php echo form_input($password_confirm+array('class'=>'form-control')); ?>
                </div> 
            </div>
            <div class="form-group">
                <label for="phone" class="col-md-6 control-label requiredField">
                    <?php echo $this->lang->line("user_create_manager_phone_no"); ?>
                </label>
                <div class ="col-md-6">
                    <?php echo form_input($phone+array('class'=>'form-control')); ?>
                </div> 
            </div>
            <div class="form-group">
                <label for="address" class="col-md-6 control-label requiredField">
                    <?php echo $this->lang->line("user_create_manager_address"); ?>
                </label>
                <div class ="col-md-6">
                    <?php echo form_input($address+array('class'=>'form-control')); ?>
                </div> 
            </div>
            <div class="form-group">
                <label for="address" class="col-md-6 control-label requiredField">

                </label>
                <div class ="col-md-3 col-md-offset-3">
                    <?php echo form_input($submit_create_manager+array('class'=>'form-control btn-success')); ?>
                </div> 
            </div>
        </div>
    </div>
    <?php echo form_close(); ?>
</div>