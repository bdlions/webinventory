<script type="text/javascript">
 var RecaptchaOptions = {
    theme : 'white'
 };
 </script>
<h3>Add New Admin</h3>
<div class ="form-horizontal form-background top-bottom-padding" >
     <?php echo form_open("user/admin_signup", array('id' => 'form_create_admin', 'class' => 'form-horizontal')); ?>
    <div class="row">
        <div class ="col-md-5 col-md-offset-2 margin-top-bottom">
            <div class ="row">
                <div class="col-md-4"></div>
                <div class="col-md-8"><?php echo $message; ?></div>
            </div>
            <div class="form-group">
                <label for="first_name" class="col-md-4 control-label requiredField">
                    First Name
                </label>
                <div class ="col-md-8">
                    <?php echo form_input($first_name + array('class' => 'form-control')); ?>
                </div> 
            </div>
            <div class="form-group">
                <label for="last_name" class="col-md-4 control-label requiredField">
                    Last Name
                </label>
                <div class ="col-md-8">
                    <?php echo form_input($last_name + array('class' => 'form-control')); ?>
                </div>
            </div>
            <div class="form-group">
                <label for="email" class="col-md-4 control-label requiredField">
                    Email ID
                </label>
                <div class ="col-md-8">
                    <?php echo form_input($email + array('class' => 'form-control')); ?>
                </div> 
            </div>
            <div class="form-group">
                <label for="phone" class="col-md-4 control-label requiredField">
                    Phone Number
                </label>
                <div class ="col-md-8">
                    <?php echo form_input($phone + array('class' => 'form-control')); ?>
                </div> 
            </div>
            <div class="form-group">
                <label for="username" class="col-md-4 control-label requiredField">
                    User Name
                </label>
                <div class ="col-md-8">
                    <?php echo form_input($username + array('class' => 'form-control')); ?>
                </div> 
            </div>
            <div class="form-group">
                <label for="password" class="col-md-4 control-label requiredField">
                    Password
                </label>
                <div class ="col-md-8">
                    <?php echo form_input($password + array('class' => 'form-control')); ?>
                </div> 
            </div>
            <div class="form-group">
                <label for="password" class="col-md-4 control-label requiredField">
                    Confirm Password
                </label>
                <div class ="col-md-8">
                    <?php echo form_input($password_confirm + array('class' => 'form-control')); ?>
                </div> 
            </div>
            
            
            <div class ="form-group">
                <div class="col-md-8 pull-right">
                    <?php 
                        $publickey = "6LctLfISAAAAAEWmA7GBCAJC7SL4bzFc5jZuDA0O";
                        echo recaptcha_get_html($publickey); 
                    ?>
                </div>
            </div>


            <div class="form-group">
                <label for="address" class="col-md-6 control-label requiredField">

                </label>
                <div class ="col-md-3 col-md-offset-3">
                    <?php echo form_input($submit_create_manager + array('class' => 'form-control btn-success')); ?>
                </div> 
            </div>
        </div>
    </div>
    <?php echo form_close(); ?>
</div>