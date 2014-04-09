<nav class="navbar navbar-default navbar-top" role="navigation">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#open-collapse"> 
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button> 
    </div>
    <div class="collapse navbar-collapse" id="open-collapse">
        <div class="container">
            <div class="row">
                <div class="col-md-6 logo-text">
                    <img class="logo" src="<?php echo base_url() ?>/assets/images/logo.png" />Apurbo Group
                </div>
                <div class="col-md-6">
                    <div class="row pull-right">
                        <!--
                        <a class="login-text" href="<?php echo base_url()?>user/salesman_login"><u>Salesman Login</u></a>
                        <br>
                        <a class="login-text" href="<?php echo base_url()?>user/admin_signup"><u>Admin Signup</u></a>
                        -->
                        <button type="button" onclick="window.location.href='user/salesman_login'">Salesman Login</button>
                        <button type="button" onclick="window.location.href='user/admin_signup'">Admin Signup</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>