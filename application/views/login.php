<style>
    .clr{clear:both;}
    *{margin:0 ; padding: 0 ; }
    *img{ border:0; } 

    .header{ background-color:#3b5999;}
    .ribbon_logo{ float:left; padding: 20px; }
    .ribbon_logo img{ float: left; }
    .login{ float: left; padding: 20px; } 
    .login div { float:left;}
    .empty1{ width: 150px; float:left;} 


    .login-color1{ color: white; font-family:verdana; font-size:12px; }
    .login-color2{ color: #a2b5db; font-size:12px; }
    .login-color2 a { color: #a2b5db; font-size:12px; } 

    .login-button{  background-color:#607cad; color:white;  border: 1px solid #5D6477; box-shadow:inset; text-align:center; width:48px; height: 20px; margin-top: 20px;}
    .login-button a { text-decoration:none ; color: white; }
    .content{ background-color: #edf0f5;}
    .empty2{ width: 500px; float:left;} 
    .body_form{ float:left; }
    .body_form form{ }

    .name input{ height:25px; width: 150px; border-radius: 3px; box-shadow: 1px 1px 1px 1px #888888; border: 1px solid #777A80; }
    .email input{ height:25px; width: 305px; border-radius: 3px; box-shadow: 1px 1px 1px 1px #888888; border: 1px solid #777A80; }

    .email{ padding: 10px 0 0 0 ; width:320px; border-radius:4px; border: 3px solid #white; }
    .footer{ background-color: #ffffff; width:1000px; }
    .signup{ padding: 20px 0 30px 0 ; border-bottom: 1px solid #827777;}
    .signup div{  background-color:#5a9048;  box-shadow:inset; border: 1px solid #5a9048; border-radius: 4px; box-shadow:inset #0FD10D; height:30px; width: 200px; text-align:center; }
    .signup a { text-decoration:none ; color: white; line-height: 30px; font-size:14px; font-family: verdana; font-weight:bold;  }
    .birthday{ padding: 5px 0 10px 0 ; }
    .page{ padding: 0 0 30px 0 ; float:right; }
    .page a { text-decoration:none; color:#435CAC; }
    .footer{ height:140px; background-color:#F4F4F4; width:100%; }
</style>
<link rel="stylesheet" type="text/css" href="">
<div class="col-md-12 container clr">
    <div class="row">
        <div class="header col-md-12">
            <div class="ribbon_logo col-md-4 pull-left">
                <img src="images/logo.png">
            </div>
            <div class="login pull-right col-md-6">
                <?php echo form_open(LOGIN_URI, array('id' => 'admin-login', 'role' => 'form', 'class' => 'form-horizontal')); ?>
                <div class="row col-md-12">
                    <div class="col-md-4">
                        <label> <span class="login-color1"><?php echo lang('login_identity_label', 'identity'); ?><br> </span> </label>
                        <?php echo form_input($identity); ?> <br>
                        <input type="checkbox">
                        <span class="login-color2" > keep me logged in</span>
                    </div>
                    <div class="col-md-4">
                        <label> <span class="login-color1"> <?php echo lang('login_password_label', 'password'); ?><br> </span> </label>
                        <?php echo form_input($password); ?><br>
                        <span class="login-color2"><a href="#">Forgot your password? </a></span>
                    </div>
                    <div class="col-md-4">
                        <input type="submit" value="Login" name="login_submit_btn" id="login_submit_btn" class="login-button">
                    </div>
                </div>
                <div class="row"><?php echo $message2; ?></div>
                <?php echo form_close(); ?>
            </div>
            <br style="clear: both;">
        </div>
    </div>
    <div class="row">
        <div class="content clr col-md-12">
            <div class="body_form col-md-offset-6 col-md-4">
                <?php echo form_open(LOGIN_URI, array('id' => 'form_create_admin', 'class' => 'form-horizontal')); ?>
                    <h1> Sign Up </h1>
                    <div class="row"><?php echo $message2; ?></div>
                    <div class="form-group">
                        <div class ="col-md-12">
                            <?php echo form_input($first_name + array('class' => 'form-control', 'placeholder'=>'First Name')); ?>
                        </div> 
                    </div>
                    <div class="form-group">
                        <div class ="col-md-12">
                            <?php echo form_input($last_name + array('class' => 'form-control', 'placeholder'=>'Last Name')); ?>
                        </div> 
                    </div>
                    <div class="form-group">
                        <div class ="col-md-12">
                            <?php echo form_input($email + array('class' => 'form-control', 'placeholder'=>'Email ID')); ?>
                        </div> 
                    </div>
                    <div class="form-group">
                        <div class ="col-md-12">
                            <?php echo form_input($phone + array('class' => 'form-control', 'placeholder'=>'Phone Number')); ?>
                        </div> 
                    </div>
                    <div class="form-group">
                        <div class ="col-md-12">
                            <?php echo form_input($username + array('class' => 'form-control', 'placeholder'=>'User Name')); ?>
                        </div> 
                    </div>
                    <div class="form-group">
                        <div class ="col-md-12">
                            <?php echo form_input($password + array('class' => 'form-control', 'placeholder'=>'Password')); ?>
                        </div> 
                    </div>
                    <div class="form-group">
                        <div class ="col-md-12">
                            <?php echo form_input($password_confirm + array('class' => 'form-control', 'placeholder'=>'Confirm Password')); ?>
                        </div> 
                    </div>
                    <div class="form-group">
                        <div class ="col-md-12">
                            <?php
                            $publickey = "6LctLfISAAAAAEWmA7GBCAJC7SL4bzFc5jZuDA0O";
                            echo recaptcha_get_html($publickey);
                            ?>
                        </div> 
                    </div>
                    <div class="form-group">
                        <div class ="col-md-4">
                            <?php echo form_input($submit_create_manager + array('class' => 'form-control btn-success')); ?>
                        </div> 
                    </div>
                    
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
</div>