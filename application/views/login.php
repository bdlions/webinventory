<style>
    .clr{clear:both;}
    *{margin:0 ;}
    *img{ border:0; } 

    .header{ background-color:#75B3E6; padding-top: 8px;}
    .ribbon_logo{ float:left;}
    .ribbon_logo img{ float: left; }
    .login{ float: left; } 
    .login div { float:left;}
    .empty1{ width: 150px; float:left;} 


    .login-color{ color: red; font-family:verdana; font-size:12px; }
    .login-color1{ color: white; font-family:verdana; font-size:12px; }
    .login-color2{ color: white; font-size:14px; vertical-align: top;}
    .login-color2 a { color: white; font-size:14px; } 

    .login-button{  background-color:#607cad; color:white;  border: 1px solid #5D6477; box-shadow:inset; text-align:center; width:48px; height: 20px; margin-top: 28px;}
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

<div class="container-fluid">
    <div class="header_background">
        <div class="row">
            <div class="col-md-offset-1 col-md-5">
                <div class="col-xs-12 col-sm-12" style="padding-top: 12px;">
                    <img src="<?php echo base_url(); ?>resources/images/webinventory.png">
                </div>
            </div>
            <div class="col-md-offset-1 col-md-4">
                <?php echo form_open(LOGIN_URI, array('id' => 'admin-login', 'role' => 'form', 'class' => 'form-horizontal')); ?>
                <div class="row">
                    <div class="col-md-5">
                        <div class="col-xs-12 col-sm-12"><label> <span class="user_login_style"><?php echo lang('login_identity_label', 'identity'); ?></span> </label></div>
                        <div class="col-xs-12 col-sm-12"><?php echo form_input($identity); ?></div>
                        <div class="col-xs-12 col-sm-12">
                            <div class="text_padding_top user_password_style"><input type="checkbox"> Keep me logged in</div>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="col-xs-12 col-sm-12"><label> <span class="user_login_style"> <?php echo lang('login_password_label', 'password'); ?> </span> </label></div>
                        <div class="col-xs-12 col-sm-12"><?php echo form_input($password); ?></div>
                        <div class="col-xs-12 col-sm-12"><div class="text_padding_top user_password_style"><a href="#">Forgot your password? </a></div></div>
                    </div>
                    <div class="col-md-2">
                        <div class="col-xs-12 col-sm-12" ><input type="submit" value="Login" name="login_submit_btn" id="login_submit_btn" class="login_button_style"></div>
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-md-12 col-xs-12 col-sm-12">
                        <div class="user_login_style"><?php echo $message1; ?></div>
                    </div>
                </div>
                <?php echo form_close(); ?>
            </div>
            <div class="col-md-1"></div>
        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="row padding_before_image">
        <div class="col-md-offset-1 col-md-5">
            <div class="left_text_style col-xs-12 col-sm-12">A complete business account solution</div>
        </div>
        <div class="col-md-offset-1 col-md-4">
            <div class="right_text_style col-xs-12 col-sm-12">Sign Up</div>
        </div>
        <div class="col-md-1"></div>
    </div>
    <div class="row">
        <div class="col-md-7">
            <div class="col-xs-12 col-sm-12">
                <img class="img-responsive" src="<?php echo base_url(); ?>resources/images/login_left_image.png">
                <div class="form-group"></div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="col-xs-12 col-sm-12">
                <?php echo form_open(LOGIN_URI, array('id' => 'form_create_admin', 'class' => 'form-horizontal')); ?>
                <div class="row">
                    <div class="col-md-12 col-xs-12 col-sm-12 message_style">
                        <?php echo $message2; ?>
                    </div>
                </div>
                <div class="row form-group">
                    <div class ="col-md-12 col-xs-12 col-sm-12 ">
                        <?php echo form_input($first_name + array('class' => 'form-control', 'placeholder' => 'First Name')); ?>
                    </div> 
                </div>
                <div class="row form-group">
                    <div class ="col-md-12 col-xs-12 col-sm-12">
                        <?php echo form_input($last_name + array('class' => 'form-control', 'placeholder' => 'Last Name')); ?>
                    </div> 
                </div>
                <div class="row form-group">
                    <div class ="col-md-12 col-xs-12 col-sm-12">
                        <?php echo form_input($email + array('class' => 'form-control', 'placeholder' => 'Email ID')); ?>
                    </div> 
                </div>
                <div class="row form-group">
                    <div class ="col-md-12 col-xs-12 col-sm-12">
                        <?php echo form_input($phone + array('class' => 'form-control', 'placeholder' => 'Phone Number')); ?>
                    </div> 
                </div>
                <div class="row form-group">
                    <div class ="col-md-12 col-xs-12 col-sm-12">
                        <?php echo form_input($username + array('class' => 'form-control', 'placeholder' => 'User Name')); ?>
                    </div> 
                </div>
                <div class="row form-group">
                    <div class ="col-md-12 col-xs-12 col-sm-12">
                        <?php echo form_input($password + array('class' => 'form-control', 'placeholder' => 'Password')); ?>
                    </div> 
                </div>
                <div class="row form-group">
                    <div class ="col-md-12 col-xs-12 col-sm-12">
                        <?php echo form_input($password_confirm + array('class' => 'form-control', 'placeholder' => 'Confirm Password')); ?>
                    </div> 
                </div>
                <div class="row form-group">
                    <div class ="col-md-11 col-xs-12 col-sm-12">
                        <?php
                        $publickey = "6LctLfISAAAAAEWmA7GBCAJC7SL4bzFc5jZuDA0O";
                        echo recaptcha_get_html($publickey);
                        ?>
                    </div> 
                    <div class ="col-md-1"></div>
                </div>
                <div class="row form-group">
                    <div class ="col-md-4 col-xs-5 col-sm-5">
                        <?php echo form_input($submit_create_manager + array('class' => 'form-control btn-success')); ?>
                    </div> 
                    <div class="col-md-8"></div>
                </div>
                <?php echo form_close(); ?>
            </div>
            <div class="col-md-1"></div>
        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="footer_style"></div>
        </div>
    </div>
</div>


