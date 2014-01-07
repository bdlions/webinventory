<script type="text/javascript">
    $(document).ready(function() {
        var customer_data = '<?php echo json_encode($customer_list_array) ?>';
        set_customer_list(JSON.parse(customer_data));

        var product_data = '<?php echo json_encode($product_list_array) ?>';
        set_product_list(JSON.parse(product_data));
    });
</script>
<script>
    function append_selected_product(prod_info)
    {
        var is_product_previously_selected = false;
        $("span", "#div_selected_product_list").each(function(){
            $("input", $(this)).each(function(){
                if ($(this).attr("name") === "quantity" )
                {
                    if( $(this).attr("id") === prod_info['id'])
                    {
                        is_product_previously_selected = true;
                    }
                }
            });
        });
        if(is_product_previously_selected === true)
        {
            alert('The product is already selected. Please update product quantity.');
            return;            
        }
        
        var current_temp_product_html = $("#div_selected_product_list").html();
        current_temp_product_html = current_temp_product_html + '<span class="span12 sales_view_block" style="">';
        current_temp_product_html = current_temp_product_html + '<input id="'+prod_info['id']+'" name="purchase_order_no" class="fl" type="text" value="1"/>';
        current_temp_product_html = current_temp_product_html + '<input name="product_code" readonly="true" class="fl" type="text" value="'+prod_info['code']+'"/>';
        current_temp_product_html = current_temp_product_html + '<input id="'+prod_info['id']+'" name="quantity" class="fl" type="text" value="1"/>';
        current_temp_product_html = current_temp_product_html + '<input readonly="true" id="'+prod_info['id']+'" class="fl" type="text" name="unit_price" value="'+prod_info['unit_price']+'"/>';
        current_temp_product_html = current_temp_product_html + '<input id="'+prod_info['id']+'" name="discount" class="fl" type="text" value="0"/>';
        current_temp_product_html = current_temp_product_html + '<input name="product_sale_price" readonly="true" class="fl" type="text" value="'+prod_info['unit_price']+'"/>';
        current_temp_product_html = current_temp_product_html + '</span>';
        $("#div_selected_product_list").html(current_temp_product_html);  
        
        var total_sale_price = 0;
        $("input", "#div_selected_product_list").each(function(){
            if ($(this).attr("name") === "product_sale_price" )
            {
                total_sale_price = +total_sale_price + +$(this).val();                    
            }
        });
        $("#total_sale_price").val( total_sale_price ); 
    }
    
    function update_fields_selected_customer(cust_info)
    {
        $("#input_add_sale_customer_id").val(cust_info['customer_id']);
        $("#input_add_sale_customer").val(cust_info['username']);
        $("#input_add_sale_card_no").val(cust_info['card_no']);
        $("#input_add_sale_phone").val(cust_info['phone']);
        
        var rString = randomString(13, '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ');
        $("#sale_order_no").val( rString );
    }
    
    function isNumber(n) {
        return !isNaN(parseFloat(n)) && isFinite(n);
    }
    
    function randomString(length, chars) {
        var result = '';
        for (var i = length; i > 0; --i) result += chars[Math.round(Math.random() * (chars.length - 1))];
        return result;
    }
</script>

<script type="text/javascript">
    $(function() {
        $("#input_date_add_sale").datepicker();
        $("#div_customer_list").on("click", "input", function() {
            if( $(this).parent() && $(this).parent().parent() && $(this).parent().parent().attr("id") === "div_customer_list" )
            {
                var c_list = get_customer_list();
                for (var counter = 0; counter < c_list.length; counter++)
                {
                    var cust_info = c_list[counter];
                    if ( $(this).attr("id") === cust_info['customer_id'] )
                    {
                        update_fields_selected_customer(cust_info);
                        $('div[class="clr dropdown open"]').removeClass('open');
                        return;
                    }
                }
            }
        });
        $("#div_product_list").on("click", "input", function() {
            if ($(this).parent() && $(this).parent().parent() && $(this).parent().parent().attr("id") === "div_product_list" )
            {
                var p_list = get_product_list();
                for (var counter = 0; counter < p_list.length; counter++)
                {
                    var prod_info = p_list[counter];
                    if ( $(this).attr("id") === prod_info['id'] )
                    {
                        append_selected_product(prod_info);
                        $('div[class="clr dropdown open"]').removeClass('open');
                        return;
                    }
                }
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
                    var current_temp_html_customer = '';
                    for (var counter = 0; counter < cust_list.length; counter++)
                    {
                        var cust_info = cust_list[counter];
                        current_temp_html_customer = current_temp_html_customer + '<span id="span_customer_info" class="span12 sales_view_block" style="">';
                        current_temp_html_customer = current_temp_html_customer + '<input id="' + cust_info['customer_id'] + '" class="fl" type="text" value="' + cust_info['phone'] + '"/>';
                        current_temp_html_customer = current_temp_html_customer + '<input id="' + cust_info['customer_id'] + '" class="fl" type="text" value="' + cust_info['card_no'] + '"/>';
                        current_temp_html_customer = current_temp_html_customer + '<span class="span10 view sales_view fl" style="">';
                        current_temp_html_customer = current_temp_html_customer + '<a target="_blank" class="view" href="<?php echo base_url(); ?>user/show_customer/' + cust_info['customer_id'] + '">view</a>';
                        current_temp_html_customer = current_temp_html_customer + '</span>';
                        current_temp_html_customer = current_temp_html_customer + '</span>';                        
                    }
                    $("#div_customer_list").html(current_temp_html_customer);
                }
            });
        });
        $("#button_search_product").on("click", function() {
            if ($("#dropdown_search_product")[0].selectedIndex == 0)
            {
                alert("Please select search criteria.");
                return false;
            }
            else if ($("#input_search_product").val().length == 0)
            {
                alert("Please assign value of search criteria");
                return false;
            }
            $.ajax({
                type: "POST",
                url: '<?php echo base_url(); ?>' + "search/search_product_order",
                data: {
                    search_category_name: $("#dropdown_search_product").val(),
                    search_category_value: $("#input_search_product").val()
                },
                success: function(data) {
                    var prod_list = JSON.parse(data);
                    set_product_list(prod_list);
                    var current_temp_html_product = '';
                    for (var counter = 0; counter < prod_list.length; counter++)
                    {
                        var prod_info = prod_list[counter];
                        current_temp_html_product = current_temp_html_product + '<span id="span_product_info" class="span12 sales_view_block" style="">';
                        current_temp_html_product = current_temp_html_product + '<input id="' + prod_info['id'] + '" class="fl" type="text" value="' + prod_info['name'] + '"/>';
                        current_temp_html_product = current_temp_html_product + '<input id="' + prod_info['id'] + '" class="fl" type="text" value="' + prod_info['code'] + '"/>';
                        current_temp_html_product = current_temp_html_product + '<span class="span10 view sales_view fl" style="">';
                        current_temp_html_product = current_temp_html_product + '<a target="_blank" class="view" href="<?php echo base_url(); ?>user/show_customer/' + prod_info['id'] + '">view</a>';
                        current_temp_html_product = current_temp_html_product + '</span>';
                        current_temp_html_product = current_temp_html_product + '</span>';                        
                    }
                    $("#div_product_list").html(current_temp_html_product);
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
                        alert('New customer is added successfully.');
                        var customer_info = response['customer_info'];
                        
                        var current_temp_html_customer = $("#div_customer_list").html();                        
                        current_temp_html_customer = current_temp_html_customer + '<span id="span_customer_info" class="span12 sales_view_block" style="">';
                        current_temp_html_customer = current_temp_html_customer + '<input id="' + customer_info['customer_id'] + '" class="fl" type="text" value="' + customer_info['phone'] + '"/>';
                        current_temp_html_customer = current_temp_html_customer + '<input id="' + customer_info['customer_id'] + '" class="fl" type="text" value="' + customer_info['card_no'] + '"/>';
                        current_temp_html_customer = current_temp_html_customer + '<span class="span10 view sales_view fl" style="">';
                        current_temp_html_customer = current_temp_html_customer + '<a target="_blank" class="view" href="<?php echo base_url(); ?>user/show_customer/' + customer_info['customer_id'] + '">view</a>';
                        current_temp_html_customer = current_temp_html_customer + '</span>';
                        current_temp_html_customer = current_temp_html_customer + '</span>';
                        $("#div_customer_list").html(current_temp_html_customer);                        
                        update_fields_selected_customer(customer_info);
                        $('div[class="clr dropdown open"]').removeClass('open');
                    }
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
                        
                        var current_temp_html_product = $("#div_product_list").html();                        
                        current_temp_html_product = current_temp_html_product + '<span id="span_product_info" class="span12 sales_view_block" style="">';
                        current_temp_html_product = current_temp_html_product + '<input id="' + product_info['id'] + '" class="fl" type="text" value="' + product_info['name'] + '"/>';
                        current_temp_html_product = current_temp_html_product + '<input id="' + product_info['id'] + '" class="fl" type="text" value="' + product_info['code'] + '"/>';
                        current_temp_html_product = current_temp_html_product + '<span class="span10 view sales_view fl" style="">';
                        current_temp_html_product = current_temp_html_product + '<a target="_blank" class="view" href="<?php echo base_url(); ?>product/show_product/' + product_info['id'] + '">view</a>';
                        current_temp_html_product = current_temp_html_product + '</span>';
                        current_temp_html_product = current_temp_html_product + '</span>';
                        $("#div_product_list").html(current_temp_html_product);
                        append_selected_product(product_info);
                        $('div[class="clr dropdown open"]').removeClass('open');
                    }
                }

            });
        });
        $("#div_selected_product_list").on("change", "input", function() {
            var product_quantity = '';
            var product_discount = '';
            var product_unit_price = '';
            var total_product_price = '';
            $("input", $(this).parent()).each(function(){
                if ($(this).attr("name") === "purchase_order_no" )
                {
                    if ( $(this).val() === '' )
                    {
                        $(this).val('1');
                        alert("Invalid Lot No.");
                        return false;
                    }
                    $(this).attr('value', $(this).val());
                }
                if ($(this).attr("name") === "quantity" )
                {
                    if ( $(this).val() === '' || $(this).val() <= 0 || !isNumber($(this).val()) )
                    {
                        $(this).val('1');
                        alert("Invalid quantity.");
                        return false;
                    }
                    $(this).attr('value', $(this).val());
                    product_quantity = $(this).val();
                }
                if ($(this).attr("name") === "unit_price" )
                {
                    product_unit_price = $(this).val();
                }
                if ($(this).attr("name") === "discount" )
                {
                    if ( $(this).val() === '' || !isNumber($(this).val()) || +$(this).val() < 0 || +$(this).val() > 100 )
                    {
                        $(this).val('0');
                        alert("Invalid discount.");
                        return false;
                    }
                    $(this).attr('value', $(this).val());
                    product_discount = $(this).val();
                }
                if ($(this).attr("name") === "product_sale_price" )
                {
                    total_product_price = (product_quantity*product_unit_price) - (product_quantity*product_unit_price*product_discount/100);
                    $(this).attr('value', total_product_price );
                    $(this).val( total_product_price );                    
                }
            });
            
            var total_sale_price = 0;
            $("input", "#div_selected_product_list").each(function(){
                if ($(this).attr("name") === "product_sale_price" )
                {
                    total_sale_price = +total_sale_price + +$(this).val(); 
                }
            });
            $("#total_sale_price").val( total_sale_price );             
        });
        $("#save_sale_order").on("click", function() {
            //validation checking of sale order
            //checking whether customer is selected or not
            if( $("#input_add_sale_customer_id").val().length === 0 || $("#input_add_sale_customer_id").val() < 0)
            {
                alert('Please select a customer');
                return;
            }
            //checking whether sale order no is empty or not
            if( $("#sale_order_no").val().length === 0)
            {
                alert('Incorrect Order #');
                return;
            }
            //checking whether at least one product is selected or not
            var selected_product_counter = 0;
            $("span", "#div_selected_product_list").each(function(){
                $("input", $(this)).each(function(){
                    if ($(this).attr("name") === "quantity" )
                    {
                        selected_product_counter++;
                    }
                });
            });
            if(selected_product_counter <= 0)
            {
                alert('Please select at least one product.');
                return;
            }
            //creating a list based on selected products
            var product_list = new Array();
            var product_list_counter = 0;
            $("span", "#div_selected_product_list").each(function(){
                var product_info = new Product();
                $("input", $(this)).each(function(){
                    if ($(this).attr("name") === "quantity" )
                    {
                        product_info.setProductId($(this).attr("id"));
                        product_info.setQuantity($(this).attr("value"));
                    }
                    if ($(this).attr("name") === "purchase_order_no" )
                    {
                        product_info.setPurchaseOrderNo($(this).attr("value"));
                    }
                    if ($(this).attr("name") === "unit_price" )
                    {
                        product_info.setUnitPrice($(this).attr("value"));
                    }
                    if ($(this).attr("name") === "discount" )
                    {
                        product_info.setDiscount($(this).attr("value"));
                    }
                    if ($(this).attr("name") === "product_sale_price" )
                    {
                        product_info.setSubTotal($(this).attr("value"));
                    }
                    if ($(this).attr("name") === "product_code" )
                    {
                        product_info.setProductCode($(this).attr("value"));
                    }
                });
                product_list[product_list_counter++] = product_info;
            });
            var sale_info = new Sale();
            sale_info.setOrderNo( $("#sale_order_no").val() );
            sale_info.setCustomerId( $("#input_add_sale_customer_id").val() );
            sale_info.setRemarks( $("#sale_remarks").val() );
            console.log(product_list);
            console.log(sale_info);
            $.ajax({
                type: "POST",
                url: '<?php echo base_url(); ?>' + "sale/add_sale",
                data: {
                    product_list: product_list,
                    sale_info: sale_info
                },
                success: function(data) {
                    var response = JSON.parse(data);
                    console.log(response);
                    if (response['status'] === '1')
                    {
                        alert('Sale order is executed successfully.');
                        $("#div_selected_product_list").html('');
                        $("#input_add_sale_customer_id").val('');
                        $("#input_add_sale_customer").val('');
                        $("#input_add_sale_company").val('');
                        $("#input_add_sale_phone").val('');
                        $("#input_add_sale_card_no").val('');
                        $("#sale_order_no").val('');
                        $("#sale_remarks").val('');
                        $("#total_sale_price").val('');
                    }
                    else if (response['status'] === '0')
                    {
                        alert(response['message']);
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
                    <span class="fr">
                        <button>Search</button>
                    </span>
                </div>
				<p class="clr">&nbsp;</p>
            </div>			
            <div class="clr search_box order-status hndrd">			
                <div class="clr">
                    <span class="fl"><h3>Order#</h3></span>
					<span class="fr"><h3>Status</h3></span>
                </div>
				<?php
					foreach ($customer_list_array as $key => $customer) {
				?>
                <div class="clr"> 
                    <span class="fl"><?php echo $customer['phone']; ?></span>
					<span class="fr"><?php echo $customer['card_no']; ?></span>                    
                </div>
				<?php
					}
				?>
				<p class="clr">&nbsp;</p>
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
                            <input id="input_add_sale_customer_id" name="input_add_sale_customer_id" type="hidden" />
                            <input class="span2" id="input_add_sale_customer" style="width:96% !important;" type="text" />
                        </span>
                    </div>
                    <div class="dropdown-menu cust_popup" style="width:300%; padding: 15px; padding-bottom: 15px;">
                        <div class="clr search_details" style="width:auto;">
                            <div style="width:100%;" class="details hundrd span9">
                                <div style="width:auto;" class="clr product_details product_details12">
                                    <div class="clr span12 sales_view_block">
                                        <div class="span4 fl"><h3>Phone</h3></div>
                                        <div class="span4 fl"><h3>Card No</h3></div>
                                        <div class="span4 fl"><h3>Details</h3></div>
                                    </div>
                                    <div id="div_customer_list" class="clr span12 sales_view_block">										
                                            <?php
                                                    foreach ($customer_list_array as $key => $customer) {
                                            ?>
                                            <span id="span_customer_info" class="span12 sales_view_block" style="">
                                                    <input id="<?php echo $customer['customer_id']; ?>" class="fl" type="text" value="<?php echo $customer['phone']; ?>"/>
                                                    <input id="<?php echo $customer['customer_id']; ?>" class="snd_raw fl" type="text" value="<?php echo $customer['card_no']; ?>"/>
                                                    <span class="span10 view sales_view fl" style=""><a target="_blank" class="view" href="<?php echo base_url()."user/show_customer/" . $customer['customer_id']; ?>">view</a></span>
                                            </span>	
                                            <?php
                                                    }
                                            ?>  										
                                            
                                    </div>                                                                       
                                </div>
                                <p class="clr">&nbsp;</p>
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
                                        <input class="span2" id="input_search_customer" name="input_search_customer" style="width:auto;" type="text" />
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
                                                <input class="span2" id="input_first_name" name="input_first_name" type="text" />
                                            </span>
                                        </div>
                                        <div class="clr">
                                            <span class="fl">Last Name</span>
                                            <span class="fr">
                                                <input class="span2" id="input_last_name" name="input_last_name" type="text" />
                                            </span>
                                        </div>
                                        <div class="clr">
                                            <span class="fl">Phone No</span>
                                            <span class="fr">
                                                <input class="span2" id="input_phone_no" name="input_phone_no" type="text" />
                                            </span>
                                        </div>
                                        <div class="clr">
                                            <span class="fl">Card No</span>
                                            <span class="fr">
                                                <input class="span2" id="input_card_no" name="input_card_no" type="text" />
                                            </span>
                                        </div>
                                        <div class="clr fr">
                                            <button id="button_add_customer" name="button_add_customer" class="btn btn-success fr">Submit </button>
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
                    <span class="fr"><input class="span2" id="input_add_sale_phone" name="input_add_sale_phone" type="text" /></span>
                </div>
                <div class="clr">
                    <span class="fl">Card No</span>
                    <span class="fr"><input class="span2" id="input_add_sale_card_no" name="input_add_sale_card_no" type="text" /></span>
                </div>
                <div class="clr">
                    <span class="fl">Address</span>
                    <span class="fr">
                        <Textarea class="span2" id="textarea_add_sale_address" name="textarea_add_sale_address"></textarea>
                    </span>
                </div>
                <p class="clr">&nbsp;</p>
                <div class="clr dropdown">                     
                    <div style ="width:250px;"class="dropdown-toggle" data-toggle="dropdown">
                        <span class="fl">Product</span>
                        <span class="fr" style="margin-left:6px;">
                            <input class="span2" id="input_add_sale_product" style="width:96% !important;" type="text" />
                        </span>
                    </div>
                    <div class="dropdown-menu cust_popup" style="width:300%; padding: 15px; padding-bottom: 15px;">
                        <div class="clr search_details" style="width:auto;">
                            <div style="width:100%;" class="details hundrd span9">
                                <div style="width:auto;" class="clr product_details product_details12">
                                    <div class="clr span12 sales_view_block">
                                        <div class="span4 fl"><h3>Product Name</h3></div>
                                        <div class="span4 fl"><h3>Product Code</h3></div>
                                        <div class="span4 fl"><h3>Details</h3></div>
                                    </div>
                                    <div id="div_product_list" class="clr span12 sales_view_block">										
                                            <?php
                                            foreach ($product_list_array as $key => $product) {
                                            ?>
                                            <span id="span_product_info" class="span12 sales_view_block" style="">
                                                <input id="<?php echo $product['id']; ?>" class="fl" type="text" value="<?php echo $product['name']; ?>"/>
                                                <input id="<?php echo $product['id']; ?>" class="snd_raw fl" type="text" value="<?php echo $product['code']; ?>"/>
                                                <span class="span10 view sales_view fl" style=""><a target="_blank" class="view" href="<?php echo base_url() . "product/show_product/" . $product['id']; ?>">view</a></span>
                                            </span>	
                                            <?php																					
                                            }
                                            ?> 
                                    </div>
                                </div>
                                <p class="clr">&nbsp;</p>
                                <div class="clr extra_customer" style="width:auto;">
                                    <div class="thirty_percnt customer1 san3">
                                        <h3>Search</h3>
                                    </div>
                                    <div class="thirty_percnt customer2 span3">
                                        <div class="clr">
                                            <div class="clr">
                                                <span class="fr">
                                                    <?php echo form_dropdown('dropdown_search_product', $product_search_category, '0', 'id="dropdown_search_product"'); ?>                                                    
                                                </span>
                                            </div>                                                                                      
                                            <p class="clr">&nbsp;</p>
                                        </div>
                                    </div>
                                    <div class="thirty_percnt customer1 san3 refresh" style="width:auto;">                                        
                                        <input class="span2" id="input_search_product" name="input_search_product" style="width:auto;" type="text" />
                                        <button id="button_search_product" name="button_search_product" class="btn btn-success fr">Search </button>
                                    </div>
                                </div>
                                <div class="clr customer_search">
                                    <div class="thirty_percnt customer1 san3">
                                        <h3>Add New</h3>
                                    </div>
                                    <div class="thirty_percnt customer2 span3">
                                        <div class="clr">
                                            <span class="fl">Product Name</span>
                                            <span class="fr">
                                                <input class="span2" id="input_product_name" name="input_product_name" type="text" />
                                            </span>
                                        </div>
                                        <div class="clr">
                                            <span class="fl">Product Code</span>
                                            <span class="fr">
                                                <input class="span2" id="input_product_code" name="input_product_code" type="text" />
                                            </span>
                                        </div>
                                        <div class="clr">
                                            <span class="fl">Unit Price</span>
                                            <span class="fr">
                                                <input class="span2" id="input_unit_price" name="input_unit_price" type="text" />
                                            </span>
                                        </div>
                                        <div class="clr fr">
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
            <div class="thirty_percnt customer2 span3">
                <div class="clr">


                </div>
                <div class="clr">


                </div>
             </div>
            <div class="thirty_percnt customer3 span3">
            <div class="clr">
               <span class="fl">Order #</span>
               <span class="fr">
                   <input class="span2" id="sale_order_no" name="sale_order_no" type="text" readonly="true"/>
               </span>
            </div>
            <div class="clr">
               <span class="fl">Date</span>
               <span class="fr">
                   <input class="span2" id="input_date_add_sale"/>
               </span>
            </div>
            <div class="clr">
               <span class="fl">Status</span>
               <span class="fr"><input class="span2" type="text" value="open" /></span>
            </div>
         </div>
      </div>
	  <p style="height:10px;">&nbsp;</p>
      <div class="clr product_details">
         <div id="div_selected_product_purchase_order_no_list">
            <h3>Lot No</h3>
         </div>
         <div id="div_selected_product_code_list">
            <h3>Product Code</h3>
         </div>
         <div id="div_selected_product_quantity_list">
            <h3>Quantity</h3>
         </div>
         <div id="div_selected_product_unit_price_list">
            <h3>Unit Price</h3>
         </div>
         <div id="div_selected_product_discount_list">
            <h3>Discount % </h3>
         </div>
         <div id="div_selected_product_sub_total_list">
            <h3>Sub-Total</h3>
         </div>
         <p style="clr:both;">&nbsp;</p>
      </div>
      <div class="clr product_details product_details13">
        <div id="div_selected_product_list" class="clr span12 sales_view_block">										
            
        </div>         
        <p style="clr:both;">&nbsp;</p>
      </div>
       <p class="clr">&nbsp;</p>
       <div class="clr payment_info">
            <div class="block block2">
               <div class="clr ">
                  <span class="fl">Remarks</span>
                  <span class="fr">
                    <textarea id="sale_remarks" name="sale_remarks"></textarea>
                  </span>										
               </div>
            </div>
            <p class="clr">&nbsp;</p>
            <div class="block block3">
               <div class="clr ">
                  <span class="fl">Total</span>
                  <span class="fr">
                      <input readonly="true" id="total_sale_price" name="total_sale_price"></input>
                  </span>										
               </div>
            </div>
           <div class="block block2">
               <div class="clr ">
                  <span class="fl">&nbsp;</span>
                  <span class="fr">
                  <input id="save_sale_order" name="save_sale_order" type="submit" value="Save"></input>
                  </span>										
               </div>
            </div>
         </div>
         <p class="clr">&nbsp;</p>
   </div>
   <p class="clr">&nbsp;</p>
</div>