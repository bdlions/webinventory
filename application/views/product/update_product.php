<h2>Update Product</h2>
<div class="clr search_details">
    <div class="clr span12">
        <div class="span12">
            <div class="row-fluid">
                <div class="tabbable">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#tabs1-pane1" data-toggle="tab">Product Info</a></li>
                    </ul>
                    <div class="tab-content">
                        <?php echo form_open("product/update_product/".$product_info['id'], array('id' => 'form_update_product')); ?>
                        <div class="tab-pane active" id="tabs1-pane1">
                            <?php echo $message;?>
                            <p class="clr">										
                            <div class="span5">
                                <fieldset>
                                    <legend>Basic</legend>
                                    <div class="clr span10">
                                        <span class="fl">Product Name</span>
                                        <span class="fr">
                                            <?php echo form_input($product_name); ?>
                                        </span>			
                                    </div>
                                    <div class="clr span10">
                                        <span class="fl">Product Size</span>
                                        <span class="fr">
                                            <input type="text" class="span2" value="" />
                                        </span>			
                                    </div>
                                    <div class="clr span10">
                                        <span class="fl">Product Weight</span>
                                        <span class="fr">
                                            <input type="text" class="span2" value="" />
                                        </span>			
                                    </div>
                                    <div class="clr span10">
                                        <span class="fl">Product Warranty</span>
                                        <span class="fr">
                                            <input type="text" class="span2" value="" />
                                        </span>			
                                    </div>	
                                    <div class="clr span10">
                                        <span class="fl">Product Quality</span>
                                        <span class="fr">
                                            <input type="text" class="span2" value="" />
                                        </span>			
                                    </div>	
                                    <div class="clr span10">
                                        <span class="fl">Brand Name</span>
                                        <span class="fr">
                                            <input type="text" class="span2" value="" />
                                        </span>			
                                    </div>	
                                </fieldset>                                		
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
                            <p class="clr"></p>											
                            </p>
                            <p class="clr">
                            <div class="span5">                                
                                <fieldset>
                                    <legend>Sales Info</legend>
                                    <div class="clr span10">
                                        <span class="fl">Unit Price</span>
                                        <span class="fr">
                                            <?php echo form_input($unit_price); ?>
                                        </span>			
                                    </div> 
                                    <div class="clr span10">
                                        <span class="fl"></span>
                                        <span class="fr">
                                            <?php echo form_submit($submit_update_product); ?>
                                        </span>			
                                    </div>                                        
                                </fieldset>                               	
                            </div>
                            <div class="span5">
                                <fieldset>
                                    <legend>Others</legend>
                                    <div class="clr span10">
                                        <span class="fl">Remarks</span>
                                        <span class="fr">
                                            <input type="text" class="span2" value="" />
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
