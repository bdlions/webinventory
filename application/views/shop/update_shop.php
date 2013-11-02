<h2>Update Shop</h2>
<div class="clr search_details">
    <div class="clr span12">
        <div class="span12">
            <div class="row-fluid">
                <div class="tabbable">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#tabs1-pane1" data-toggle="tab">Shop Info</a></li>
                    </ul>
                    <div class="tab-content">
                        <?php echo form_open("shop/update_shop/".$shop_info['id'], array('id' => 'form_update_shop')); ?>
                        <div class="tab-pane active" id="tabs1-pane1">
                            <?php echo $message;?>
                            <p class="clr">										
                            <div class="span5">
                                    <fieldset>
                                        <legend>Basic</legend>
                                        <div class="clr span10">
                                            <span class="fl">Shop No</span>
                                            <span class="fr">
                                                <?php echo form_input($shop_no); ?>
                                            </span>			
                                        </div>
                                        <div class="clr span10">
                                            <span class="fl">Shop Name *</span>
                                            <span class="fr">
                                                <?php echo form_input($shop_name); ?>
                                            </span>			
                                        </div> 
                                        <div class="clr span10">
                                            <span class="fl">Shop Phone</span>
                                            <span class="fr">
                                                <?php echo form_input($shop_phone); ?>
                                            </span>			
                                        </div>
                                        <div class="clr span10">
                                            <span class="fl">Shop Address *</span>
                                            <span class="fr">
                                                <?php echo form_input($shop_address); ?>
                                            </span>			
                                        </div> 
                                        <div class="clr span10">
                                            <span class="fl"></span>
                                            <span class="fr">
                                                <?php echo form_submit($submit_update_shop); ?>
                                            </span>			
                                        </div> 
                                    </fieldset>
                                </form>		
                            </div>
                            <div class="span5">
                                <fieldset>
                                    <legend>Picture</legend>
                                    <div class="clr span10">
                                        <span class="clr">
                                            <input type="file" class="span2" value="Browse" />
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
