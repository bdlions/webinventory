<h2>Update Product</h2>
<div class="clr search_details">
    <div class="clr span12">
        <div class="span12">
            <div class="row-fluid">
                <div class="tabbable">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#tabs1-pane2" data-toggle="tab">Product Details</a></li>								
                        <li class=""><a href="#tabs1-pane3" data-toggle="tab">Product Info</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="tabs1-pane2">
                            <p class="clr">										
                            <div class="clr">
                                <form>
                                    <fieldset>
                                        <legend>Create product</legend>
                                        <div class="clr span5">
                                            <span class="fl">Product ID</span>
                                            <span class="fr">
                                                <input type="text" class="span2" value="Shop No." />
                                            </span>			
                                        </div>														
                                        <div class="clr span5">
                                            <span class="fl">Product Name</span>
                                            <span class="fr">
                                                <input type="text" class="span2" value="Shop Name" />
                                            </span>			
                                        </div>														
                                        <div class="clr span5">
                                            <span class="fl">Product Type</span>
                                            <span class="fr">
                                                <select>
                                                    <option>Product Type</option>
                                                    <option>Type-1</option>
                                                    <option>Type-2</option>
                                                    <option>Type-3</option>
                                                    <option>Type-4</option>
                                                    <option>Type-5</option>
                                                </select>
                                                <select name="myselect">
                                                    <option value="one" <?php echo set_select('myselect', 'one', TRUE); ?> >One</option>
                                                    <option value="two" <?php echo set_select('myselect', 'two'); ?> >Two</option>
                                                    <option value="three" <?php echo set_select('myselect', 'three'); ?> >Three</option>
                                                </select> 
                                            </span>			
                                        </div>
                                        <div class="clr span5">
                                            <span class="fl">Brand Name</span>
                                            <span class="fr">
                                                <select>
                                                    <option>Brands Name</option>
                                                    <option>Dell</option>
                                                    <option>Asus</option>
                                                    <option>Lenovo</option>
                                                    <option>Fujitsu</option>
                                                </select>
                                                <select name="myselect">
                                                    <option value="one" <?php echo set_select('myselect', 'one', TRUE); ?> >One</option>
                                                    <option value="two" <?php echo set_select('myselect', 'two'); ?> >Two</option>
                                                    <option value="three" <?php echo set_select('myselect', 'three'); ?> >Three</option>
                                                </select> 
                                            </span>			
                                        </div>														
                                        <div class="clr span5">
                                            <span class="fl">Quality</span>
                                            <span class="fr">
                                                <select>
                                                    <option>Quality</option>
                                                    <option>Super Fine</option>
                                                    <option>Good</option>
                                                    <option>Normal</option>
                                                </select>
                                                <select name="myselect">
                                                    <option value="one" <?php echo set_select('myselect', 'one', TRUE); ?> >One</option>
                                                    <option value="two" <?php echo set_select('myselect', 'two'); ?> >Two</option>
                                                    <option value="three" <?php echo set_select('myselect', 'three'); ?> >Three</option>
                                                </select> 
                                            </span>			
                                        </div>
                                        <div class="clr span5">
                                            <span class="fl">Size</span>
                                            <span class="fr">
                                                <select>
                                                    <option>Select Weight(kg)</option>
                                                    <option>1</option>
                                                    <option>2</option>
                                                    <option>3</option>
                                                    <option>4</option>
                                                    <option>5</option>
                                                </select>
                                                <select name="myselect">
                                                    <option value="one" <?php echo set_select('myselect', 'one', TRUE); ?> >One</option>
                                                    <option value="two" <?php echo set_select('myselect', 'two'); ?> >Two</option>
                                                    <option value="three" <?php echo set_select('myselect', 'three'); ?> >Three</option>
                                                </select> 
                                            </span>			
                                        </div>														
                                        <div class="clr span5">
                                            <span class="fl">Weight</span>
                                            <span class="fr">
                                                <select>
                                                    <option>Select Weight</option>
                                                    <option>1</option>
                                                    <option>2</option>
                                                    <option>3</option>
                                                    <option>4</option>
                                                    <option>5</option>
                                                    <option>6</option>
                                                    <option>7</option>
                                                    <option>8</option>
                                                    <option>9</option>
                                                    <option>10</option>
                                                </select>
                                                <select name="myselect">
                                                    <option value="one" <?php echo set_select('myselect', 'one', TRUE); ?> >One</option>
                                                    <option value="two" <?php echo set_select('myselect', 'two'); ?> >Two</option>
                                                    <option value="three" <?php echo set_select('myselect', 'three'); ?> >Three</option>
                                                </select> 
                                            </span>			
                                        </div>
                                        <div class="clr span5">
                                            <span class="fl">Warranty (years)</span>
                                            <span class="fr">
                                                <select>
                                                    <option>Select Duration</option>
                                                    <option>2</option>
                                                    <option>3</option>
                                                    <option>4</option>
                                                    <option>5</option>
                                                    <option>6</option>
                                                </select>
                                                <select name="myselect">
                                                    <option value="one" <?php echo set_select('myselect', 'one', TRUE); ?> >One</option>
                                                    <option value="two" <?php echo set_select('myselect', 'two'); ?> >Two</option>
                                                    <option value="three" <?php echo set_select('myselect', 'three'); ?> >Three</option>
                                                </select> 
                                            </span>			
                                        </div>														
                                        <div class="clr span5">
                                            <span class="fl">Unit Price</span>
                                            <span class="fr">
                                                <input type="text" class="span2" value="$123" />
                                            </span>			
                                        </div>
                                    </fieldset>
                                </form>		
                            </div>
                            <p class="clr"></p>											
                            </p>
                        </div>
                        <div class="tab-pane" id="tabs1-pane3">
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
