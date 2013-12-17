<script type="text/javascript">
    $(document).ready(function(){
        var customer_data  = '<?php echo json_encode($customer_list_array) ?>';
        set_customer_list(JSON.parse(customer_data));
        
        var product_data = '<?php echo json_encode($product_list_array) ?>';
        set_product_list(JSON.parse(product_data))
        
    });
</script>

<script type="text/javascript">
    $(function() {
        $("#input_date_add_sale").datepicker();
        $("input").on("click", function(){
            console.log($(this).val());
            $("#input_add_sale_customer").val($(this).val());
        });
        $("#button_search_customer").on("click", function() {
            if($("#dropdown_search_customer")[0].selectedIndex == 0)
            {
                alert("Please select search criteria.");
                return false;
            }
            else if( $("#input_search_customer").val().length == 0 )
            {
                alert("Please assign value of search criteria");
                return false;
            }
            $.ajax({
                type: "POST",
                url: '<?php echo base_url(); ?>' + "search/search_customer_sale_order",
                data: {
                    search_category_name: $("#dropdown_search_customer").val(),
                    search_category_value: $("#input_search_customer").val()
                },
                success: function(data) {
                    var cust_list = JSON.parse(data);
                }

            });
        });
        $("#button_add_customer").on("click", function() {
            if( $("#input_first_name").val().length == 0 )
            {
                alert("First Name is required.");
                return;
            }
            else if( $("#input_last_name").val().length == 0 )
            {
                alert("Last Name is required.");
                return;
            }
            else if( $("#input_phone_no").val().length == 0 )
            {
                alert("Phone is required.");
                return;
            }
            else if( $("#input_card_no").val().length == 0 )
            {
                alert("Card No is required.");
                return;
            }
            $.ajax({
                type: "POST",
                url: '<?php echo base_url(); ?>' + "user/create_customer_sale_order",
                data: {
                    first_name: $("#input_first_name").val(),
                    last_name: $("#input_last_name").val(),
                    phone_no: $("#input_phone_no").val(),
                    card_no: $("#input_card_no").val()

                },
                success: function(data) {
                    console.log(get_customer_list());
                    var response = JSON.parse(data);
                    if (response['status'] === '1')
                    {
                        var c_list = get_customer_list();
                        c_list[c_list.length] = response['customer_info'];
                        set_customer_list(c_list);
                        alert('New customer is added successfully.');
                        var customer_info = response['customer_info'];
                        var current_temp_html = $("#phone_customer_list").html();
                        current_temp_html = current_temp_html + '<input class="snd_raw" type="text" value="'+customer_info['phone']+'"/>';
                        $("#phone_customer_list").html(current_temp_html);
                        
                        current_temp_html = $("#card_no_customer_list").html();
                        current_temp_html = current_temp_html + '<input class="snd_raw" type="text" value="'+customer_info['card_no']+'"/>';
                        $("#card_no_customer_list").html(current_temp_html);
                        
                        current_temp_html = $("#detail_customer_list").html();
                        current_temp_html = current_temp_html + '<div class="span10 view sales_view"><a target="_blank" class="view" href="<?php echo base_url();?>user/show_customer/'+customer_info['id']+'">view</a></div>';
                        $("#detail_customer_list").html(current_temp_html);
                        
                        $("#input_add_sale_customer").val(customer_info['phone']);
                    }
                    $('div[class="clr dropdown open"]').removeClass('open');
                }

            });
        });

        $("#button_add_product").on("click", function() {
            if( $("#input_product_name").val().length == 0 )
            {
                alert("Product Name is required.");
                return;
            }
            else if( $("#input_product_code").val().length == 0 )
            {
                alert("Product Code is required.");
                return;
            }
            else if( $("#input_unit_price").val().length == 0 )
            {
                alert("Unit Price is required.");
                return;
            }
            $.ajax({
                type: "POST",
                url: '<?php echo base_url(); ?>' + "product/create_product_sale_order",
                data: {
                    product_name: $("#input_product_name").val(),
                    product_code: $("#input_product_code").val(),
                    unit_price: $("#input_unit_price").val()
                },
                success: function(data) {
                    var response = JSON.parse(data);
                    if (response['status'] === '1')
                    {
                        var p_list = get_product_list();
                        p_list[p_list.length] = response['product_info'];
                        set_product_list(p_list);
                        alert('New product is added successfully.');
                        var product_info = response['product_info'];
                        var current_temp_html = $("#name_product_list").html();
                        current_temp_html = current_temp_html + '<input type="text" value="'+product_info['name']+'"/>';
                        $("#name_product_list").html(current_temp_html);
                        
                        current_temp_html = $("#code_product_list").html();
                        current_temp_html = current_temp_html + '<input type="text" value="'+product_info['code']+'"/>';
                        $("#code_product_list").html(current_temp_html);
                        
                        current_temp_html = $("#unit_price_product_list").html();
                        current_temp_html = current_temp_html + '<input type="text" value="'+product_info['unit_price']+'"/>';
                        $("#unit_price_product_list").html(current_temp_html);
                        
                        current_temp_html = $("#detail_product_list").html();
                        current_temp_html = current_temp_html + '<div class="view sales_view"><a target="_blank" class="view" href="<?php echo base_url();?>product/show_product/'+product_info['id']+'">view</a></div>';
                        $("#detail_product_list").html(current_temp_html);
                    }
                }

            });
        });
    });
</script>
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
                        <span class="fr" style="margin-left:6px;">
                            <input id="input_add_sale_customer" style="width:96% !important;" type="text" />
                        </span>
                    </div>
                    <div class="dropdown-menu cust_popup" style="width: 255%; padding: 15px; padding-bottom: 15px;">
                        <div class="clr search_details">
                            <div style="width:auto;" class="details hundrd span9">
                                <div style="width:auto;" class="clr product_details">
                                    <div style="width:auto;" class="blank_div">
                                        <p style="background-image:none;">&nbsp;</p>
                                        <?php
                                        foreach ($customer_list_array as $key => $customer) {
                                            ?>
                                            <p>&nbsp;</p>
                                            <?php
                                        }
                                        ?> 
                                    </div>
                                    <div id="phone_customer_list" class="span3 sales_view_block">
                                        <h3>Phone</h3>
                                        <?php
                                        foreach ($customer_list_array as $key => $customer) {
                                            ?>
                                            <input class="snd_raw" type="text" value="<?php echo $customer['phone']; ?>"/>
                                            <?php
                                        }
                                        ?>                              
                                    </div>
                                    <div id="card_no_customer_list" class="span3 sales_view_block">
                                        <h3>Card No</h3>
                                        <?php
                                        foreach ($customer_list_array as $key => $customer) {
                                            ?>
                                            <input class="snd_raw" type="text" value="<?php echo $customer['card_no']; ?>"/>
                                            <?php
                                        }
                                        ?> 
                                    </div>
                                    <div id="detail_customer_list" class="span3 sales_view_block sales_view_block1">
                                        <h3>Details</h3>
                                        <?php
                                        foreach ($customer_list_array as $key => $customer) {
                                            ?> 
                                            <div class="span10 view sales_view"><a target="_blank" class="view" href="<?php echo base_url()."user/show_customer/" . $customer['id']; ?>">view</a></div>
                                            <?php
                                        }
                                        ?>                              
                                    </div>
                                    <p class="clr">&nbsp;</p>
                                </div>
                                <div class="clr extra_customer">
                                    <div class="thirty_percnt customer1 san3">
                                        <h3>Search</h3>
                                    </div>
                                    <div class="thirty_percnt customer2 span3">
                                        <div class="clr">
                                            <div class="clr">
                                                <span class="fr">
                                                    <?php echo form_dropdown('dropdown_search_customer',$customer_search_category,'0','id="dropdown_search_customer"');?>                                                    
                                                </span>
                                            </div>                                                                                      
                                            <p class="clr">&nbsp;</p>
                                        </div>
                                    </div>
                                    <div class="thirty_percnt customer1 san3 refresh">                                        
                                        <input id="input_search_customer" name="input_search_customer" class="clr" type="text" />
                                        <button id="button_search_customer" name="button_search_customer" class="btn btn-success fr">Search </button>
                                    </div>
                                </div>
                                <div class="clr customer_search">
                                    <div class="thirty_percnt customer1 san3">
                                        <h3>Add New</h3>
                                    </div>
                                    <div class="thirty_percnt customer2 span3">
                                        <div class="clr">
                                            <span class="fl">First Name</span>
                                            <span class="fr">
                                                <input id="input_first_name" name="input_first_name" type="text" />
                                            </span>
                                        </div>
                                        <div class="clr">
                                            <span class="fl">Last Name</span>
                                            <span class="fr">
                                                <input id="input_last_name" name="input_last_name" type="text" />
                                            </span>
                                        </div>
                                        <div class="clr">
                                            <span class="fl">Phone No</span>
                                            <span class="fr">
                                                <input id="input_phone_no" name="input_phone_no" type="text" />
                                            </span>
                                        </div>
                                        <div class="clr">
                                            <span class="fl">Card No</span>
                                            <span class="fr">
                                                <input id="input_card_no" name="input_card_no" type="text" />
                                            </span>
                                        </div>
                                        <div class="clr fr">
                                            <button id="button_add_customer" name="button_add_customer" class="btn btn-success">Submit </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <p class="clr">&nbsp;</p>
                        </div>
                    </div>
                </div>

                <div class="clr">
                    <span class="fl">Phone</span>
                    <span class="fr"><input type="text" /></span>
                </div>
                <div class="clr">
                    <span class="fl">Card No</span>
                    <span class="fr"><input type="text" /></span>
                </div>
                <div class="clr">
                    <span class="fl">Address</span>
                    <span class="fr">
                        <Textarea></textarea>
               </span>
            </div>
         </div>          
         <div class="thirty_percnt customer2 span3">
            <div class="clr">
               
               
            </div>
            <div class="clr">
               
               
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
                   <input id="input_date_add_sale"/>
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
                      <span class="fr"><input type="text" value="" /></span>
               </div>
               <div class="dropdown-menu cust_popup_product" style="width: 255%; padding: 15px; padding-bottom: 15px;">
                  <div class="clr search_details">					
                    <div class="details hundrd span9">										
                            <div class="clr product_details">
                                    <div style="width:3%;border:0;" class="blank_div">
                                            <p style="background-image:none;">&nbsp;</p>
                                        <?php
                                        foreach ($product_list_array as $key => $product_info) {
                                            ?>
                                                <p>&nbsp;</p>
                                            <?php
                                        }
                                        ?> 
                                    </div>
                                    <div id="name_product_list" class="span3 sales_view_block">
                                            <h3>Product Name</h3>
                                        <?php
                                        foreach ($product_list_array as $key => $product_info) {
                                            ?>
                                                <input type="text" value="<?php echo $product_info['name']; ?>"/>
                                            <?php
                                        }
                                        ?>
                                    </div>
                                    <div id="code_product_list" class="span3 sales_view_block">
                                            <h3>Product Code</h3>
                                        <?php
                                        foreach ($product_list_array as $key => $product_info) {
                                            ?>
                                                <input type="text" value="<?php echo $product_info['code']; ?>"/>
                                            <?php
                                        }
                                        ?>
                                    </div>
                                    <div id="unit_price_product_list" class="span3 sales_view_block">
                                            <h3>Unit Price</h3>
                                        <?php
                                        foreach ($product_list_array as $key => $product_info) {
                                            ?>
                                                <input type="text" value="<?php echo $product_info['unit_price']; ?>"/>
                                            <?php
                                        }
                                        ?>
                                    </div>
                                    <div id="detail_product_list" class="span2 sales_view_block sales_view_block1">
                                            <h3>Details</h3>
                                        <?php
                                        foreach ($product_list_array as $key => $product_info) {
                                            ?>
                                                <div class="view sales_view"><a target="_blank" class="view" href="<?php echo base_url()."product/show_product/" . $product_info['id']; ?>">view</a></div>
                                            <?php
                                        }
                                        ?>
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
                                                <span class="fl">Product Name</span>
                                                <span class="fr">
                                                    <input id="input_product_name" name="input_product_name" type="text" />
                                                </span>
                                            </div>	
                                            <div class="clr span12">
                                                <span class="fl">Product Code</span>
                                                <span class="fr">
                                                    <input id="input_product_code" name="input_product_code" type="text" />
                                                </span>
                                            </div>
                                            <div class="clr span12">
                                                <span class="fl">Unit Price</span>
                                                <span class="fr">
                                                    <input id="input_unit_price" name="input_unit_price" type="text" />
                                                </span>
                                            </div>
                                            <div class="clr span12">
                                                <button id="button_add_product" name="button_add_product" class="btn btn-success fr">Submit </button>
                                            </div>
                                    </div>
                            </div>
                    </div>
                    <p class="clr">&nbsp;</p>
            </div>
               </div>
            </div>
         </div>
         <div>
            <h3>Description</h3>
            <input type="text" value=""/>
         </div>
         <div>
            <h3>Quantity</h3>
            <input type="text" value=""/>
         </div>
         <div>
            <h3>Unit Price</h3>
            <input type="text" value=""/>
         </div>
         <div>
            <h3>Discount</h3>
            <input type="text" value=""/>
         </div>
         <div>
            <h3>Sub-Total</h3>
            <input type="text" value=""/>
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