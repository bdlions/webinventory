<script type="text/javascript">
    $(document).ready(function() {
        var customer_data = '<?php echo json_encode($customer_list_array) ?>';
        set_customer_list(JSON.parse(customer_data));

        var product_data = '<?php echo json_encode($product_list_array) ?>';
        set_product_list(JSON.parse(product_data));
    });
</script>

<script type="text/javascript">
    $(function() {
        $("#input_date_add_sale").datepicker();
        $("#div_customer_list").on("click", "input", function() {
            //$("input").on("click", function() {
            console.log('clicked.');
            console.log($(this));
            console.log($(this).parent());
            if ($(this).parent() && $(this).parent().attr("id") && ($(this).parent().attr("id") === "phone_customer_list" || $(this).parent().attr("id") === "card_no_customer_list"))
            {
                var c_list = get_customer_list();
                console.log(get_customer_list());
                for (var counter = 0; counter < c_list.length; counter++)
                {
                    var cust_info = c_list[counter];
                    console.log(cust_info['phone']);
                    console.log($(this).val());
                    if (($(this).parent().attr("id") === "phone_customer_list" && cust_info['phone'] === $(this).val()) || ($(this).parent().attr("id") === "card_no_customer_list" && cust_info['card_no'] === $(this).val()))
                    {
                        $("#input_add_sale_customer").val(cust_info['username']);
                        $("#input_add_sale_card_no").val(cust_info['card_no']);
                        $("#input_add_sale_phone").val(cust_info['phone']);

                        $('div[class="clr dropdown open"]').removeClass('open');
                        return;
                    }
                }
                console.log('not found.');
            }
        });
        $("#div_product_list").on("click", "input", function() {
            if ($(this).parent() && $(this).parent().attr("id") && ($(this).parent().attr("id") === "name_product_list" || $(this).parent().attr("id") === "code_product_list"))
            {
                var p_list = get_product_list();
                for (var counter = 0; counter < p_list.length; counter++)
                {
                    var prod_info = p_list[counter];
                    console.log(prod_info['name']);
                    console.log($(this).val());
                    if (($(this).parent().attr("id") === "name_product_list" && prod_info['name'] === $(this).val()) || ($(this).parent().attr("id") === "code_product_list" && cust_info['code'] === $(this).val()))
                    {
                        current_temp_html = $("#card_no_customer_list").html();
                        current_temp_html = current_temp_html + '<input class="snd_raw" type="text" value="' + customer_info['card_no'] + '"/>';
                        $("#card_no_customer_list").html(current_temp_html);
                        $('div[class="clr dropdown cust_popup_product_block open"]').removeClass('open');
                        return;
                    }
                }
                console.log('not found.');
            }
        });
        $("#button_search_customer").on("click", function() {
            if ($("#dropdown_search_customer")[0].selectedIndex == 0)
            {
                alert("Please select search criteria.");
                return false;
            }
            else if ($("#input_search_customer").val().length == 0)
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
                    set_customer_list(cust_list);
                    var current_temp_html_phone = '';
                    var current_temp_html_card_no = '';
                    var current_temp_html_details = '';
                    for (var counter = 0; counter < cust_list.length; counter++)
                    {
                        var cust_info = cust_list[counter];
                        current_temp_html_phone = current_temp_html_phone + '<input class="snd_raw" type="text" value="' + cust_info['phone'] + '"/>';
                        current_temp_html_card_no = current_temp_html_card_no + '<input class="snd_raw" type="text" value="' + cust_info['card_no'] + '"/>';
                        current_temp_html_details = current_temp_html_details + '<div class="span10 view sales_view"><a target="_blank" class="view" href="<?php echo base_url(); ?>user/show_customer/' + cust_info['id'] + '">view</a></div>';
                    }
                    $("#phone_customer_list").html(current_temp_html_phone);
                    $("#card_no_customer_list").html(current_temp_html_card_no);
                    $("#detail_customer_list").html(current_temp_html_details);
                }

            });
        });
        $("#button_add_customer").on("click", function() {
            if ($("#input_first_name").val().length == 0)
            {
                alert("First Name is required.");
                return;
            }
            else if ($("#input_last_name").val().length == 0)
            {
                alert("Last Name is required.");
                return;
            }
            else if ($("#input_phone_no").val().length == 0)
            {
                alert("Phone is required.");
                return;
            }
            else if ($("#input_card_no").val().length == 0)
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
                    var response = JSON.parse(data);
                    if (response['status'] === '1')
                    {
                        var c_list = get_customer_list();
                        c_list[c_list.length] = response['customer_info'];
                        set_customer_list(c_list);
                        console.log(get_customer_list());
                        alert('New customer is added successfully.');
                        var customer_info = response['customer_info'];
                        var current_temp_html = $("#phone_customer_list").html();
                        current_temp_html = current_temp_html + '<input class="snd_raw" type="text" value="' + customer_info['phone'] + '"/>';
                        $("#phone_customer_list").html(current_temp_html);

                        current_temp_html = $("#card_no_customer_list").html();
                        current_temp_html = current_temp_html + '<input class="snd_raw" type="text" value="' + customer_info['card_no'] + '"/>';
                        $("#card_no_customer_list").html(current_temp_html);

                        current_temp_html = $("#detail_customer_list").html();
                        current_temp_html = current_temp_html + '<div class="span10 view sales_view"><a target="_blank" class="view" href="<?php echo base_url(); ?>user/show_customer/' + customer_info['id'] + '">view</a></div>';
                        $("#detail_customer_list").html(current_temp_html);

                        //$("#input_add_sale_customer").val(customer_info['phone']);
                        $("#input_add_sale_customer").val(customer_info['username']);
                        $("#input_add_sale_card_no").val(customer_info['card_no']);
                        $("#input_add_sale_phone").val(customer_info['phone']);
                    }
                    $('div[class="clr dropdown open"]').removeClass('open');
                }

            });
        });

        $("#button_add_product").on("click", function() {
            if ($("#input_product_name").val().length == 0)
            {
                alert("Product Name is required.");
                return;
            }
            else if ($("#input_product_code").val().length == 0)
            {
                alert("Product Code is required.");
                return;
            }
            else if ($("#input_unit_price").val().length == 0)
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
                        current_temp_html = current_temp_html + '<input type="text" value="' + product_info['name'] + '"/>';
                        $("#name_product_list").html(current_temp_html);

                        current_temp_html = $("#code_product_list").html();
                        current_temp_html = current_temp_html + '<input type="text" value="' + product_info['code'] + '"/>';
                        $("#code_product_list").html(current_temp_html);

                        current_temp_html = $("#unit_price_product_list").html();
                        current_temp_html = current_temp_html + '<input type="text" value="' + product_info['unit_price'] + '"/>';
                        $("#unit_price_product_list").html(current_temp_html);

                        current_temp_html = $("#detail_product_list").html();
                        current_temp_html = current_temp_html + '<div class="view sales_view"><a target="_blank" class="view" href="<?php echo base_url(); ?>product/show_product/' + product_info['id'] + '">view</a></div>';
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
                    <div class="dropdown-menu cust_popup" style="width:300%; padding: 15px; padding-bottom: 15px;">
                        <div class="clr search_details" style="width:auto;">
                            <div style="width:100%;" class="details hundrd span9">
                                <div style="width:auto;" class="clr product_details">
                                    <div class="clr span12 sales_view_block">
                                        <div class="span4 fl"><h3>Phone</h3></div>
                                        <div class="span4 fl"><h3>Card No</h3></div>
                                        <div class="span4 fl"><h3>Details</h3></div>
                                    </div>
                                    <div id="div_customer_list" class="clr span12 sales_view_block">										
                                        <span id="phone_customer_list" class="span3 sales_view_block">
                                            <?php
                                            foreach ($customer_list_array as $key => $customer) {
                                                ?>
                                                <input class="snd_raw" type="text" value="<?php echo $customer['phone']; ?>"/>
                                                <?php
                                            }
                                            ?>                              
                                        </span>
                                        <span id="card_no_customer_list" class="span3 sales_view_block">
                                            <?php
                                            foreach ($customer_list_array as $key => $customer) {
                                                ?>
                                                <input class="snd_raw" type="text" value="<?php echo $customer['card_no']; ?>"/>
                                                <?php
                                            }
                                            ?> 
                                        </span>
                                        <span id="detail_customer_list" class="span3 sales_view_block sales_view_block1">
                                            <?php
                                            foreach ($customer_list_array as $key => $customer) {
                                                ?> 
                                                <div class="span10 view sales_view"><a target="_blank" class="view" href="<?php echo base_url() . "user/show_customer/" . $customer['id']; ?>">view</a></div>
                                                <?php
                                            }
                                            ?>                              
                                        </span>
                                        <p class="clr">&nbsp;</p>
                                    </div>                                    
                                </div>
                                <div class="clr extra_customer" style="width:auto;">
                                    <div class="thirty_percnt customer1 san3">
                                        <h3>Search</h3>
                                    </div>
                                    <div class="thirty_percnt customer2 span3">
                                        <div class="clr">
                                            <div class="clr">
                                                <span class="fr">
                                                    <?php echo form_dropdown('dropdown_search_customer', $customer_search_category, '0', 'id="dropdown_search_customer"'); ?>                                                    
                                                </span>
                                            </div>                                                                                      
                                            <p class="clr">&nbsp;</p>
                                        </div>
                                    </div>
                                    <div class="thirty_percnt customer1 san3 refresh" style="width:auto;">                                        
                                        <input id="input_search_customer" name="input_search_customer" style="width:auto;" class="clr" type="text" />
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
                    <span class="fr"><input id="input_add_sale_phone" name="input_add_sale_phone" type="text" /></span>
                </div>
                <div class="clr">
                    <span class="fl">Card No</span>
                    <span class="fr"><input id="input_add_sale_card_no" name="input_add_sale_card_no" type="text" /></span>
                </div>
                <div class="clr">
                    <span class="fl">Address</span>
                    <span class="fr">
                        <Textarea id="textarea_add_sale_address" name="textarea_add_sale_address"></textarea>
                    </span>
                </div>
                <div class="clr dropdown">                     
                    <div style ="width:250px;"class="dropdown-toggle" data-toggle="dropdown">
                        <span class="fl">Product</span>
                        <span class="fr" style="margin-left:6px;">
                            <input id="input_add_sale_customer" style="width:96% !important;" type="text" />
                        </span>
                    </div>
                    <div class="dropdown-menu cust_popup" style="width:300%; padding: 15px; padding-bottom: 15px;">
                        <div class="clr search_details" style="width:auto;">
                            <div style="width:100%;" class="details hundrd span9">
                                <div style="width:auto;" class="clr product_details">
                                    <div class="clr span12 sales_view_block">
                                        <div class="span4 fl"><h3>Phone</h3></div>
                                        <div class="span4 fl"><h3>Card No</h3></div>
                                        <div class="span4 fl"><h3>Details</h3></div>
                                    </div>
                                    <div id="div_customer_list" class="clr span12 sales_view_block">										
                                        <span id="phone_customer_list" class="span3 sales_view_block">
                                            <?php
                                            foreach ($customer_list_array as $key => $customer) {
                                                ?>
                                                <input class="snd_raw" type="text" value="<?php echo $customer['phone']; ?>"/>
                                                <?php
                                            }
                                            ?>                              
                                        </span>
                                        <span id="card_no_customer_list" class="span3 sales_view_block">
                                            <?php
                                            foreach ($customer_list_array as $key => $customer) {
                                                ?>
                                                <input class="snd_raw" type="text" value="<?php echo $customer['card_no']; ?>"/>
                                                <?php
                                            }
                                            ?> 
                                        </span>
                                        <span id="detail_customer_list" class="span3 sales_view_block sales_view_block1">
                                            <?php
                                            foreach ($customer_list_array as $key => $customer) {
                                                ?> 
                                                <div class="span10 view sales_view"><a target="_blank" class="view" href="<?php echo base_url() . "user/show_customer/" . $customer['id']; ?>">view</a></div>
                                                <?php
                                            }
                                            ?>                              
                                        </span>
                                        <p class="clr">&nbsp;</p>
                                    </div>                                    
                                </div>
                                <div class="clr extra_customer" style="width:auto;">
                                    <div class="thirty_percnt customer1 san3">
                                        <h3>Search</h3>
                                    </div>
                                    <div class="thirty_percnt customer2 span3">
                                        <div class="clr">
                                            <div class="clr">
                                                <span class="fr">
                                                    <?php echo form_dropdown('dropdown_search_customer', $customer_search_category, '0', 'id="dropdown_search_customer"'); ?>                                                    
                                                </span>
                                            </div>                                                                                      
                                            <p class="clr">&nbsp;</p>
                                        </div>
                                    </div>
                                    <div class="thirty_percnt customer1 san3 refresh" style="width:auto;">                                        
                                        <input id="input_search_customer" name="input_search_customer" style="width:auto;" class="clr" type="text" />
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
                            <div class="clr span12 sales_view_block sales_view_block11">
                                    <div class="span3 fl"><h3>Product Name</h3></div>
                                    <div class="span3 fl"><h3>Product Code</h3></div>
                                    <div class="span3 fl"><h3>Unit Price</h3></div>
                                    <div class="span3 fl"><h3>Details</h3></div>
                            </div>
                            <div id="div_product_list" class="clr span12 sales_view_block sales_view_block11">										
                                    <span id="name_product_list" class="span3 sales_view_block">
                                            <?php
                                            foreach ($product_list_array as $key => $product_info) {
                                                ?>
                                                                                                <input type="text" value="<?php echo $product_info['name']; ?>"/>
                                                <?php
                                            }
                                            ?>                              
                                                                    </span>
                                                                    <span id="code_product_list" class="span3 sales_view_block">
                                            <?php
                                            foreach ($product_list_array as $key => $product_info) {
                                                ?>
                                                                                                <input type="text" value="<?php echo $product_info['code']; ?>"/>
                                                <?php
                                            }
                                            ?> 
                                                                    </span>
                                                                    <span id="unit_price_product_list" class="span3 sales_view_block sales_view_block1">
                                            <?php
                                            foreach ($product_list_array as $key => $product_info) {
                                                ?>
                                                                                                <input type="text" value="<?php echo $product_info['unit_price']; ?>"/>
                                                <?php
                                            }
                                            ?>                              
                                                                    </span>
                                                                    <span id="detail_product_list" class="span2 sales_view_block sales_view_block1">
                                            <?php
                                            foreach ($product_list_array as $key => $product_info) {
                                                ?>
                                                                                                <div class="view sales_view"><a target="_blank" class="view" href="<?php echo base_url() . "product/show_product/" . $product_info['id']; ?>">view</a></div>
                                                <?php
                                            }
                                            ?>
                                                                    </span>
                                <p class="clr">&nbsp;</p>
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