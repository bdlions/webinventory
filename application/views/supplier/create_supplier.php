<h2>Create Supplier</h2>
<div class="clr search_details">
    <div class="clr span12">
        <div class="span12">
            <div class="row-fluid">
                <div class="tabbable">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#tabs1-pane1" data-toggle="tab">Supplier Info</a></li>								
                    </ul>
                    <div class="tab-content">
                        <?php echo form_open("user/create_supplier", array('id' => 'form_create_supplier')); ?>
                        <div class="tab-pane active" id="tabs1-pane1">
                            <?php echo $message;?>
                            <p class="clr">										
                            <div class="clr">
                                <div class="fifty fl span6">
                                    <fieldset>
                                        <legend>General Information</legend>
                                        <div class="clr span10">
                                            <span class="fl">User Name</span>
                                            <span class="fr">
                                                <?php echo form_input($user_name); ?>
                                            </span>			
                                        </div>
                                        <div class="clr span10">
                                            <span class="fl">Email *</span>
                                            <span class="fr">
                                                <?php echo form_input($email); ?>
                                            </span>			
                                        </div>
                                        <div class="clr span10">
                                            <span class="fl">Confirm Email</span>
                                            <span class="fr">
                                                <input type="text" class="span2" value="" />
                                            </span>			
                                        </div>
                                        <div class="clr span10">
                                            <span class="fl">Password *</span>
                                            <span class="fr">
                                                <?php echo form_input($password); ?>
                                            </span>			
                                        </div>
                                        <div class="clr span10">
                                            <span class="fl">Confirm Password</span>
                                            <span class="fr">
                                                <input type="text" class="span2" value="" />
                                            </span>			
                                        </div>
                                        <div class="clr span10">
                                            <span class="fl">First Name</span>
                                            <span class="fr">
                                                <input type="text" class="span2" value="" />
                                            </span>			
                                        </div>
                                        <div class="clr span10">
                                            <span class="fl">Last Name</span>
                                            <span class="fr">
                                                <input type="text" class="span2" value="" />
                                            </span>			
                                        </div>
                                        <div class="clr span10">
                                            <span class="fl">Phone</span>
                                            <span class="fr">
                                                <input type="text" class="span2" value="" />
                                            </span>			
                                        </div>                                            
                                    </fieldset>
                                </div>
                                <div class="fifty fr span6">
                                    <form>
                                        <fieldset>
                                            <legend>Picture</legend>
                                            <div class="clr span10">
                                                <span class="clr">
                                                    <input type="file" class="span2" value="Browse" />
                                                </span>			
                                            </div> 															
                                        </fieldset>
                                    </form>		
                                </div>
                            </div>
                            <div class="clr">
                                <div class="fifty fl span6">
                                    <fieldset>
                                        <legend>Supplier Information</legend>
                                        <div class="clr span10">
                                            <span class="fl">Company</span>
                                            <span class="fr">
                                                <?php echo form_input($company_name); ?>
                                            </span>			
                                        </div>                                                                                     
                                    </fieldset>	
                                </div>
                                <div class="fifty fr span6">
                                    <fieldset>
                                        <legend></legend>
                                        <div class="clr span10">
                                            <span class="fl">
                                                <?php echo form_submit($submit_create_supplier); ?>
                                            </span>			
                                        </div>                                                                                     
                                    </fieldset>
                                </div>
                            </div>	
                            </p>

                        </div>
                        <?php echo form_close(); ?>
                    </div>
                </div>
            </div>
            <hr>
        </div>
    </div>				
    <p class="clr">&nbsp;</p>
</div>