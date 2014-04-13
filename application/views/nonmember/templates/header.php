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
                    <img class="logo" src="<?php echo base_url() ?>/assets/images/logo.png" />
                </div>
                <div class="col-md-6">
                    <div class="row pull-right">
                      
                        <button type="button" class="btn btn-primary custom-col" onclick="window.location.href='<?php echo base_url() ?>user/salesman_login'">
							 <span class="glyphicon glyphicon-hand-right"> </span>  Salesman LogIn	
						
						</button>
                        <button type="button" class="btn btn-primary custom-col" onclick="window.location.href='<?php echo base_url() ?>user/manager_login'">
							 <span class="glyphicon glyphicon-hand-right"> </span>	Admin LogIn
						
						</button>
                        <button type="button" class="btn btn-primary custom-col" onclick="window.location.href='<?php echo base_url() ?>user/admin_signup'">
							 <span class="glyphicon glyphicon-hand-right"> </span>	Admin SignUp
						
						</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>