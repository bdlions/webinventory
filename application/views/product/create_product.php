<h2>Create Product</h2>
<div class="clr search_details">
    <div class="clr span12">
        <div class="span12">
            <div class="row-fluid">
                <div class="tabbable">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#tabs1-pane1" data-toggle="tab">Product Info</a></li>								
                        <li class=""><a href="#tabs1-pane2" data-toggle="tab">Extra Info</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="tabs1-pane1">
                            <p class="clr">										
                            <div class="span5">
                                <form>
                                    <fieldset>
                                        <legend>Basic</legend>
                                        <div class="clr span10">
                                            <span class="fl">Product Name</span>
                                            <span class="fr">
                                                <input type="text" class="span2" value="" />
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
                                </form>		
                            </div>
                            <div class="span5">
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
                            <p class="clr"></p>											
                            </p>
                            <p class="clr">
                            <div class="span5">
                                <form>
                                    <fieldset>
                                        <legend>Sales Info</legend>
                                        <div class="clr span10">
                                            <span class="fl">Unit Price</span>
                                            <span class="fr">
                                                <input type="text" class="span2" value="" />
                                            </span>			
                                        </div>                                        	
                                    </fieldset>
                                </form>		
                            </div>
                            <div class="span5">
                                <form>
                                    <fieldset>
                                        <legend>Remarks</legend>
                                        <div class="clr span10">
                                            <span class="fr">
                                                <input type="text" class="span2" value="" />
                                            </span>			
                                        </div>                                        	
                                    </fieldset>
                                </form>		
                            </div>
                        </div>
                        <div class="tab-pane" id="tabs1-pane2">
                            <p class="clr">										
                            <div class="span5">
                                <form>
                                    <fieldset>
                                        <legend>Basic</legend>
                                        <div class="clr span10">
                                            <span class="fl">Item Name/Code</span>
                                            <span class="fr">
                                                <input type="text" class="span2" value="Item Name/Code" />
                                            </span>			
                                        </div>														
                                        <div class="clr span10">
                                            <span class="fl">Category</span>
                                            <span class="fr">
                                                <select>
                                                    <option>Default Category</option>
                                                    <option>Add New</option>
                                                </select>
                                                <select name="myselect">
                                                    <option value="one" <?php echo set_select('myselect', 'one', TRUE); ?> >One</option>
                                                    <option value="two" <?php echo set_select('myselect', 'two'); ?> >Two</option>
                                                    <option value="three" <?php echo set_select('myselect', 'three'); ?> >Three</option>
                                                </select> 
                                            </span>			
                                        </div>														
                                        <div class="clr span10">
                                            <span class="fl">Type</span>
                                            <span class="fr">
                                                <select>
                                                    <option>Stockable</option>
                                                    <option>Non-Stockable</option>
                                                    <option>Service</option>
                                                </select>
                                                <select name="myselect">
                                                    <option value="one" <?php echo set_select('myselect', 'one', TRUE); ?> >One</option>
                                                    <option value="two" <?php echo set_select('myselect', 'two'); ?> >Two</option>
                                                    <option value="three" <?php echo set_select('myselect', 'three'); ?> >Three</option>
                                                </select> 
                                            </span>			
                                        </div>														
                                    </fieldset>
                                </form>		
                            </div>
                            <div class="span5">
                                <form>
                                    <fieldset>
                                        <legend>Picture</legend>
                                        <div class="clr span10">
                                            <span class="clr">
                                                <img src="./sales_order12.png" width="" height="" />
                                            </span>
                                            <span class="clr">
                                                <input type="file" class="span2" value="Browse" />
                                                <input type="text" class="span2" value="clear" style="float:right;" />
                                            </span>			
                                        </div>
                                    </fieldset>
                                </form>		
                            </div>
                            <p class="clr"></p>											
                            </p>
                            <p class="clr">										
                            <div class="span5">
                                <form>
                                    <fieldset>
                                        <legend>Sales Info</legend>
                                        <div class="clr span10">
                                            <span class="fl">Tax Code</span>
                                            <span class="fr">
                                                <select>
                                                    <option>Taxable</option>
                                                    <option>Non-taxable</option>
                                                    <option>Add new</option>
                                                </select>
                                                <select name="myselect">
                                                    <option value="one" <?php echo set_select('myselect', 'one', TRUE); ?> >One</option>
                                                    <option value="two" <?php echo set_select('myselect', 'two'); ?> >Two</option>
                                                    <option value="three" <?php echo set_select('myselect', 'three'); ?> >Three</option>
                                                </select> 
                                            </span>			
                                        </div>	
                                        <div class="clr span10">
                                            <span class="fl">Normal Price</span>
                                            <span class="fr">
                                                <input type="text" class="span2" value="$10.00" />
                                            </span>			
                                        </div>
                                    </fieldset>
                                </form>		
                            </div>
                            <div class="span5">
                                <form>
                                    <fieldset>
                                        <legend>Costing Info</legend>
                                        <div class="clr span10">
                                            <span class="fl">Costing Method</span>
                                            <span class="fr">
                                                <select>
                                                    <option>Manual</option>
                                                    <option>Moving Average</option>
                                                    <option>last Purchase</option>
                                                </select>
                                                <select name="myselect">
                                                    <option value="one" <?php echo set_select('myselect', 'one', TRUE); ?> >One</option>
                                                    <option value="two" <?php echo set_select('myselect', 'two'); ?> >Two</option>
                                                    <option value="three" <?php echo set_select('myselect', 'three'); ?> >Three</option>
                                                </select> 
                                            </span>			
                                        </div>	
                                        <div class="clr span10">
                                            <span class="fl">Edit/History</span>
                                            <span class="fr">
                                                <input type="text" class="span2" value="edit/history" />
                                            </span>			
                                        </div>
                                    </fieldset>
                                </form>		
                            </div>
                            <p class="clr"></p>											
                            </p>
                            <p class="clr">										
                            <div class="span5">
                                <form>
                                    <fieldset>
                                        <legend>Inventory</legend>
                                        <div class="clr span10">
                                            <div class="clr product_details sales_order_details">
                                                <div style="width:6%;" class="blank_div">
                                                    <p style="background-image:none;">&nbsp;</p>
                                                    <p>&nbsp;</p>
                                                    <p>&nbsp;</p>
                                                    <p>&nbsp;</p>
                                                </div>
                                                <div class="span5">
                                                    <h3>Location</h3>
                                                    <input type="text" value="Default Location"/>
                                                    <input class="snd_raw" type="text" value="lake City"/>
                                                    <input type="text" value="Pink City"/>
                                                </div>
                                                <div class="span5">
                                                    <h3>Quantity</h3>
                                                    <input type="text" value="0"/>
                                                    <input class="snd_raw" type="text" value="0"/>
                                                    <input type="text" value="0"/>
                                                </div>
                                                <p class="clr">&nbsp;</p>
                                            </div>
                                        </div>															
                                    </fieldset>
                                </form>		
                            </div>											
                            <p class="clr"></p>											
                            </p>
                        </div>                
                    </div>
                </div>
            </div>
            <hr>
        </div>
    </div>				
    <p class="clr">&nbsp;</p>
</div>
