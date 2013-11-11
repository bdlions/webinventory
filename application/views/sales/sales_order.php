<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>

<link rel="stylesheet" type="text/css" href="css/bootstrap.css" ></link>

<script type="text/javascript">
    $(function() {
        $('.dropdown-toggle').dropdown();
        $('.dropdown').click(function(e) {
            e.stopPropagation();
        });

    });
</script>

<h2>Sales Order</h2>
<div class="clr search_details">
   <div class="search span3">
      <h6>Search</h6>
      <div class="clr">
         <div class="clr search_box">
            <div class="clr">
               <span class="fl">Order#</span>
               <span class="fr"><input type="text" /></span>
            </div>
            <div class="clr">
               <span class="fl">Status</span>
               <span class="fr">
                  <select>
                     <option>All</option>
                     <option>test</option>
                     <option>test</option>
                     <option>test</option>
                  </select>
               </span>
            </div>
            <div class="clr">
               <span class="fl">Customer</span>
               <span class="fr">
                  <select class="">
                     <option>Rahim</option>
                     <option>Karim</option>
                     <option>billal</option>
                  </select>
               </span>
            </div>
            <div class="clr more_link">
               <span class="fl"> <a href="#">>more</a></span>
               <span class="fr">
               <button>Search</button>
               </span>
            </div>
         </div>
         <div class="clr order-status hndrd">
            <div class="fifty fl">
               <h3>Order#</h3>
               <div class="clr">SO-000009</div>
               <div class="clr">SO-000008</div>
               <div class="clr">SO-000007</div>
            </div>
            <div class="fifty fr">
               <h3>Status</h3>
               <div class="clr">Open</div>
               <div class="clr">In Progress</div>
               <div>Paid</div>
            </div>
         </div>
      </div>
   </div>
   <div class="details_nav hundrd span8">
      <ul>
         <li><a href="#">New</a></li>
         <li><a href="#">Save</a></li>
         <li><a href="#">Print</a></li>
         <li><a href="#">Duplicate</a></li>
         <li><a href="#">Versions</a></li>
         <li><a href="#">Add Sticky</a></li>
         <li><a href="#">Close</a></li>
      </ul>
   </div>
   <div class="details hundrd span9">
      <div class="clr">
         <div class="thirty_percnt customer1 san3">

            <div class="clr dropdown">                     
               <div style ="width:250px;"class="dropdown-toggle" data-toggle="dropdown">
                      <span class="fl">Customer</span>
                      <span class="fr" style="margin-left:6px;"><input style="width:96% !important;" type="text" /></span>
               </div>
               <div class="dropdown-menu cust_popup" style="width: 255%; padding: 15px; padding-bottom: 15px;">
                  <div class="clr search_details">
                     <div style="width:auto;" class="details hundrd span9">
                        <div style="width:auto;" class="clr product_details">
                           <div style="width:auto;" class="blank_div">
                              <p style="background-image:none;">&nbsp;</p>
                              <p>&nbsp;</p>
                              <p>&nbsp;</p>
                              <p>&nbsp;</p>
                           </div>
                           <div class="span3 sales_view_block">
                              <h3>Name</h3>
                              <input type="text" value="Noor"/>
                              <input class="snd_raw" type="text" value="Noor"/>
                              <input type="text" value="Khan"/>
                           </div>
                           <div class="span3 sales_view_block">
                              <h3>Contact</h3>
                              <input type="text" value="+8801914191945"/>
                              <input class="snd_raw" type="text" value="8801914191945"/>
                              <input type="text" value="8801914191945"/>
                           </div>
                           <div class="span3 sales_view_block sales_view_block1">
                              <h3>Details</h3>
                              <div class="span10 view sales_view"><a class="view" href="#">view</a></div>
                              <div class="span10 view snd_raw sales_view"><a class="view" href="#">view</a></div>
                              <div class="span10 view sales_view"><a class="view" href="#">view</a></div>
                           </div>
                           <p class="clr">&nbsp;</p>
                        </div>
                        <div class="clr extra_customer">
                           <div class="thirty_percnt customer1 san3">
                              <h3>Search</h3>
                           </div>
                           <div class="thirty_percnt customer2 span3">                               
                                    <?php echo form_open();?>
                              <div class="clr">
                                 <div class="clr show_all">Show All</div>
                                 <div class="clr">
                                    <span class="fr">
                                       <select>
                                          <option>Name</option>
                                          <option>Contact</option>
                                          <option>Phone</option>
                                          <option>Email</option>
                                          <option>Website</option>
                                          <option>Address1</option>
                                          <option>Address2</option>
                                          <option>City</option>
                                          <option>State</option>
                                          <option>Zip/Postal Code</option>
                                          <option>Country</option>
                                       </select>
                                    </span>
                                 </div>
                                 <div class="clr">
                                    <span class="fr">
                                       <select>
                                          <option>Naame</option>
                                          <option>Contact</option>
                                          <option>Phone</option>
                                          <option>Email</option>
                                          <option>Website</option>
                                          <option>Address1</option>
                                          <option>Address2</option>
                                          <option>City</option>
                                          <option>State</option>
                                          <option>Zip/Postal Code</option>
                                          <option>Country</option>
                                       </select>
                                    </span>
                                 </div>
                                 <div class="clr">
                                    <span class="fr">
                                       <select>
                                          <option>Name</option>
                                          <option>Contact</option>
                                          <option>Phone</option>
                                          <option>Email</option>
                                          <option>Website</option>
                                          <option>Address1</option>
                                          <option>Address2</option>
                                          <option>City</option>
                                          <option>State</option>
                                          <option>Zip/Postal Code</option>
                                          <option>Country</option>
                                       </select>
                                    </span>
                                 </div>
                                 <p class="clr">&nbsp;</p>
                              </div>
                               
                              <?php echo form_close();?>
                           </div>
                            <div class="thirty_percnt customer1 san3 refresh">
                                <div class="clr">
                                    <select>
                                        <option>Active</option>
                                        <option>Inactive</option>
                                        <option>Show All</option>
                                    </select>
                                 </div>
                                <input class="clr" type="text" />
                                <input class="clr" type="text" />
                                <input class="clr" type="text" />
                                <button class="btn btn-success fr">Refresh </button>
                            </div>
                        </div>
                        <div class="clr customer_search">
                           <div class="thirty_percnt customer1 san3">
                              <h3>Add New</h3>
                           </div>
                           <div class="thirty_percnt customer2 span3">
                              <div class="clr">
                                 <span class="fl">Name</span>
                                 <span class="fr"><input type="text" /></span>
                              </div>
                              <div class="clr">
                                 <span class="fl">Phone</span>
                                 <span class="fr"><input type="text" /></span>
                              </div>
                              <div class="clr fr"><button class="btn btn-success">Submit </button></div>
                           </div>
                        </div>
                     </div>
                     <p class="clr">&nbsp;</p>
                  </div>
               </div>
            </div>
            
            <div class="clr">
               <span class="fl">Contact</span>
               <span class="fr"><input type="text" /></span>
            </div>
            <div class="clr">
               <span class="fl">Phone</span>
               <span class="fr"><input type="text" /></span>
            </div>
            <div class="clr">
               <span class="fl">Address</span>
               <span class="fr">
               <Textarea>Box 491, New South Wales, Australia.</textarea>
               </span>
            </div>
         </div>          
         <div class="thirty_percnt customer2 span3">
            <div class="clr">
               <span class="fl">Sales Rep</span>
               <span class="fr">
                  <select>
                     <option>All</option>
                     <option>test</option>
                     <option>test</option>
                     <option>test</option>
                  </select>
               </span>
            </div>
            <div class="clr">
               <span class="fl">Location</span>
               <span class="fr">
                  <select>
                     <option>All</option>
                     <option>test</option>
                     <option>test</option>
                     <option>test</option>
                  </select>
               </span>
            </div>
         </div>
         <div class="thirty_percnt customer3 span3">
            <div class="clr">
               <span class="fl">Order #</span>
               <span class="fr"><input type="text" /></span>
            </div>
            <div class="clr">
               <span class="fl">Date</span>
               <span class="fr">
                  <select>
                     <option>All</option>
                     <option>test</option>
                     <option>test</option>
                     <option>test</option>
                  </select>
               </span>
            </div>
            <div class="clr">
               <span class="fl">Status</span>
               <span class="fr"><input type="text" value="open" /></span>
            </div>
         </div>
      </div>
	  <p style="height:10px;">&nbsp;</p>
      <div class="clr product_details">
         <div style="width:3%;" class="blank_div">
            <p style="background-image:none;">&nbsp;</p>
            <p>&nbsp;</p>
            <p>&nbsp;</p>
            <p>&nbsp;</p>
         </div>
         <div class="product_pop">
            <h3>Item</h3>
            <div class="clr dropdown cust_popup_product_block">                     
               <div style ="width:250px;border: 0 none;width: 52%;"class="dropdown-toggle" data-toggle="dropdown">
                      <span class="fr"><input type="text" value="Acer" /></span>
               </div>
               <div class="dropdown-menu cust_popup_product" style="width: 255%; padding: 15px; padding-bottom: 15px;">
                  <div class="clr search_details">					
                    <div class="details hundrd span9">										
                            <div class="clr product_details">
                                    <div style="width:3%;border:0;" class="blank_div">
                                            <p style="background-image:none;">&nbsp;</p>
                                            <p>&nbsp;</p>
                                            <p>&nbsp;</p>
                                            <p>&nbsp;</p>
                                    </div>
                                    <div class="span3 sales_view_block">
                                            <h3>Category</h3>
                                            <input type="text" value="Noor"/>
                                            <input class="snd_raw" type="text" value="Noor"/>
                                            <input type="text" value="Khan"/>
                                    </div>
                                    <div class="span3 sales_view_block">
                                            <h3>Item</h3>
                                            <input type="text" value="+8801914191945"/>
                                            <input class="snd_raw" type="text" value="8801914191945"/>
                                            <input type="text" value="8801914191945"/>
                                    </div>
                                    <div class="span3 sales_view_block">
                                            <h3>Normal Price</h3>
                                            <input type="text" value="+8801914191945"/>
                                            <input class="snd_raw" type="text" value="8801914191945"/>
                                            <input type="text" value="8801914191945"/>
                                    </div>
                                    <div class="span2 sales_view_block sales_view_block1">
                                            <h3>Details</h3>
                                            <div class="view sales_view"><a class="view" href="#">view</a></div>
                                            <div class="view snd_raw sales_view"><a class="view" href="#">view</a></div>
                                            <div class="view sales_view"><a class="view" href="#">view</a></div>
                                    </div>							
                                    <p class="clr">&nbsp;</p>
                            </div>
                            <div class="clr extra_customer">
                                <div class="thirty_percnt customer1 san3">						
                                        <h3>Search</h3>
                                </div>
                                <div class="thirty_percnt customer2 span3">					
                                    <div class="clr show_all">Show All</div>
                                    <div class="clr span12">
                                            <span class="fl">
                                                    <select>
                                                            <option>Show</option>
                                                            <option>Item Name/Code</option>
                                                            <option>Description</option>
                                                            <option>Type</option>
                                                            <option>Category</option>
                                                            <option>Price From</option>
                                                            <option>Price To</option>
                                                            <option>Barcode</option>
                                                            <option>Vendor</option>
                                                    </select>
                                            </span>                                                        
                                    </div>																					
                                    <div class="clr span12">
                                            <span class="fl">
                                                    <select>
                                                            <option>Show</option>
                                                            <option>Item Name/Code</option>
                                                            <option>Description</option>
                                                            <option>Type</option>
                                                            <option>Category</option>
                                                            <option>Price From</option>
                                                            <option>Price To</option>
                                                            <option>Barcode</option>
                                                            <option>Vendor</option>
                                                    </select>
                                            </span>                                                        
                                    </div>													
                                    <div class="clr span12">
                                            <span class="fl">
                                                    <select>
                                                            <option>Show</option>
                                                            <option>Item Name/Code</option>
                                                            <option>Description</option>
                                                            <option>Type</option>
                                                            <option>Category</option>
                                                            <option>Price From</option>
                                                            <option>Price To</option>
                                                            <option>Barcode</option>
                                                            <option>Vendor</option>
                                                    </select>
                                            </span>                                                        
                                    </div>
                                </div>
                                <div class="thirty_percnt customer1 san3 refresh">
                                    <div class="clr span12">
                                        <select>
                                            <option>Active</option>
                                            <option>Inactive</option>
                                            <option>Show All</option>
                                        </select>
                                    </div>
                                    <input class="clr" type="text" />
                                    <input class="clr" type="text" />
                                    <input class="clr" type="text" />
                                    <button class="btn btn-success fr">Refresh </button>
                                </div>
                            </div>
                            <div class="clr customer_search">
                                    <div class="thirty_percnt customer1 san3">						
                                            <h3>Add New</h3>
                                    </div>
                                    <div class="thirty_percnt customer2 span3">						
                                            <div class="clr span12">
                                                    <span class="fl">Item Name/Code</span>
                                                    <span class="fr"><input type="text" /></span>
                                            </div>	
                                            <div class="clr span12"><button class="btn btn-success fr">Submit </button></div>
                                    </div>
                            </div>
                    </div>
                    <p class="clr">&nbsp;</p>
            </div>
               </div>
            </div>
            <input type="text" value="0000047"/>
            <input type="text" value="0000047"/>
         </div>
         <div>
            <h3>Description</h3>
            <input type="text" value="Acer"/>
            <input class="snd_raw" type="text" value="dell"/>
            <input type="text" value="asus"/>
         </div>
         <div>
            <h3>Quantity</h3>
            <input type="text" value="Acer"/>
            <input class="snd_raw" type="text" value="dell"/>
            <input type="text" value="asus"/>
         </div>
         <div>
            <h3>Unit Price</h3>
            <input type="text" value="Acer"/>
            <input class="snd_raw" type="text" value="dell"/>
            <input type="text" value="asus"/>
         </div>
         <div>
            <h3>Discount</h3>
            <input type="text" value="Acer"/>
            <input class="snd_raw" type="text" value="dell"/>
            <input type="text" value="asus"/>
         </div>
         <div>
            <h3>Sub-Total</h3>
            <input type="text" value="Acer"/>
            <input class="snd_raw" type="text" value="dell"/>
            <input type="text" value="asus"/>
         </div>
		 <p style="clr:both;">&nbsp;</p>
      </div>
       <div class="clr payment_info">
            <div class="block block1">
               <div class="clr ">
                  <span class="fl">Taxing Scheme</span>
                  <span class="fr">
                     <select>
                        <option>No Tax</option>
                        <option>Add New</option>
                     </select>
                  </span>
               </div>
               <div class="clr ">
                  <span class="fl">Pricing/Currency</span>
                  <span class="fr">
                     <select>
                        <option>Normal Price</option>
                        <option>Add New</option>
                     </select>
                  </span>
               </div>
            </div>
            <div class="block block2">
               <div class="clr ">
                  <span class="fl">Remarks</span>
                  <span class="fr">
                  <textarea></textarea>
                  </span>										
               </div>
            </div>
            <div class="block block3">
               <div class="clr ">
                  <span class="fl">Sub-Total</span>
                  <span class="fr">
                  $0.00
                  </span>										
               </div>
               <div class="clr ">
                  <span class="fl">Total</span>
                  <span class="fr">
                  $0.00
                  </span>										
               </div>
            </div>
         </div>
         <p class="clr">&nbsp;</p>
   </div>
   <p class="clr">&nbsp;</p>
</div>