<script type="text/javascript">
    $(function() {
        // Setup form validation on the #register-form element
        /*$("#admin-login").validate({
            // Specify the validation rules
            rules: {
                identity: {
                    required: true
                },
                password: {
                    required: true
                },
            },
            // Specify the validation error messages
            messages: {
                identity: {
                    required: "required"
                },
                password: {
                    required: "required"
                },
            }
        });*/
    });
</script>
<div class="container">
    <div class="row">
        <div class="col-md-4"></div>
        <div class ="col-md-4 col-md-offset-4 boxshad">
            <div class =" row">
                <div class ="col-md-12">
                    <h1><?php echo lang('login_heading'); ?></h1>
                </div>
            </div>
            <div class="row">
                <div class ="col-md-12 login-subheading">
                    <?php echo lang('login_subheading'); ?>
                </div>
            </div>

            <div id="message" ><?php echo $message; ?></div>

            <?php echo form_open(ADMIN_LOGIN_SUCCESS_URI, array('id' => 'admin-login', 'role' => 'form', 'class' => 'form-horizontal')); ?>
            <div class="form-group">
                <label for="identity" class="col-md-4 control-label requiredField">
                    <?php echo lang('login_identity_label', 'identity'); ?>
                </label>
                <div class ="col-md-6">
                    <?php echo form_input($identity + array('class' => 'form-control')); ?>
                </div> 
            </div>

            <div class="form-group">
                <label for="password" class="col-md-4 control-label requiredField">
                    <?php echo lang('login_password_label', 'password'); ?>
                </label>
                <div class ="col-md-6">
                    <?php echo form_input($password + array('class' => 'form-control')); ?>
                </div> 
            </div>


            <div class="form-group">
                <label for="remember" class="col-md-4 control-label requiredField">
                    <?php echo lang('login_remember_label', 'remember'); ?>
                </label>
                <div class ="col-md-6">
                    <?php echo form_checkbox('remember', '1', FALSE, 'id="remember"'); ?>
                </div> 
            </div>

            <div class="form-group">                
                <div class ="col-md-offset-4 col-md-6">
                    <?php echo form_submit('submit', lang('login_submit_btn')); ?>
                </div> 
            </div>    

            <?php echo form_close(); ?>
            <div class ="row">                
                <div class ="col-md-offset-4 col-md-6">
                    <a href="forgot_password"><?php echo lang('login_forgot_password'); ?></a>
                </div>
            </div>
        </div>
    </div>
</div>
