<h2>Set Shop</h2>
<div class="clr search_details">
    <div class="clr span12">
        <div class="span12">
            <div class="row-fluid">
                <div class="tabbable">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#tabs1-pane1" data-toggle="tab">Shop Info</a></li>
                    </ul>
                    <div class="tab-content">
                        <?php echo form_open("shop/set_shop", array('id' => 'form_set_shop')); ?>
                        <div class="tab-pane active" id="tabs1-pane1">
                            <?php echo $message;?>
                            <p class="clr">										
                            <div class="span5">
                                    <fieldset>
                                        <legend></legend>
                                        <div class="clr span10">
                                            <span class="fl">Select Shop</span>
                                            <span class="fr">
                                                <?php echo form_dropdown('shop_list', $shop_list, $select_shop_id); ?> 
                                            </span>			
                                        </div>                                         
                                        <div class="clr span10">
                                            <span class="fl"></span>
                                            <span class="fr">
                                                <?php echo form_submit($submit_set_shop+array('class'=>'btn btn-success pull-right')); ?>
                                            </span>			
                                        </div> 
                                    </fieldset>
                                </form>		
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
