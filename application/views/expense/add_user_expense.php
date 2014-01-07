<h2>Add User Expense</h2>
<div class="clr search_details">
    <div class="clr span12">
        <div class="span12">
            <div class="row-fluid">
                <div class="tabbable">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#tabs1-pane1" data-toggle="tab">Expense Info</a></li>
                    </ul>
                    <div class="tab-content">
                        <?php echo form_open("expense/add_user_expense", array('id' => 'form_add_user_expense')); ?>
                        <div class="tab-pane active" id="tabs1-pane1">
                            <?php echo $message;?>
                            <p class="clr">										
                            <div class="span5">
                                <fieldset>
                                    <div class="clr span10">
                                        <span class="fl">&nbsp;</span>
                                        <span class="fr">
                                            &nbsp;
                                        </span>			
                                    </div>
                                    <div class="clr span10">
                                        <span class="fl">Select Supplier</span>
                                        <span class="fr">
                                            <?php echo form_dropdown('user_list', $user_list); ?>
                                        </span>			
                                    </div>
                                    <div class="clr span10">
                                        <span class="fl">Expense Description</span>
                                        <span class="fr">
                                            <?php echo form_input($expense_description); ?>
                                        </span>			
                                    </div>
                                    <div class="clr span10">
                                        <span class="fl">Expense Amount</span>
                                        <span class="fr">
                                            <?php echo form_input($expense_amount); ?>
                                        </span>			
                                    </div>  
                                    <div class="clr span10">
                                        <span class="fl"></span>
                                        <span class="fr">
                                            <?php echo form_submit($submit_add_user_expense); ?>
                                        </span>			
                                    </div>                                      
                                </fieldset>                                		
                            </div>                     
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
