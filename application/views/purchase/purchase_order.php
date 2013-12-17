<script type="text/javascript">
    $(document).ready(function() {
        var supplier_data = '<?php echo json_encode($supplier_list_array) ?>';
        set_supplier_list(JSON.parse(supplier_data));

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
        current_temp_product_html = current_temp_product_html + '<input readonly="true" class="fl" type="text" value="'+prod_info['name']+'"/>';
        current_temp_product_html = current_temp_product_html + '<input readonly="true" class="fl" type="text" value="'+prod_info['code']+'"/>';
        current_temp_product_html = current_temp_product_html + '<input id="'+prod_info['id']+'" name="quantity" class="fl" type="text" value="1"/>';
        current_temp_product_html = current_temp_product_html + '<input id="'+prod_info['id']+'" name="price" class="fl" type="text" value="100"/>';
        current_temp_product_html = current_temp_product_html + '<input name="product_buy_price" readonly="true" class="fl" type="text" value="100"/>';
        current_temp_product_html = current_temp_product_html + '</span>';
        $("#div_selected_product_list").html(current_temp_product_html);
        
        var total_purchase_price = 0;
        $("input", "#div_selected_product_list").each(function(){
            if ($(this).attr("name") === "product_buy_price" )
            {
                total_purchase_price = +total_purchase_price + +$(this).val();                    
            }
        });
        $("#total_purchase_price").val( total_purchase_price ); 
    }
    
    function update_fields_selected_supplier(sup_info)
    {
        $("#input_add_purchase_supplier_id").val(sup_info['supplier_id']);
        $("#input_add_purchase_supplier").val(sup_info['username']);
        $("#input_add_purchase_company").val(sup_info['company']);
        $("#input_add_purchase_phone").val(sup_info['phone']);
    }
    
    function isNumber(n) {
        return !isNaN(parseFloat(n)) && isFinite(n);
    }
</script>

<script type="text/javascript">
    $(function() {
        $("#input_date_add_purchase").datepicker();
        $("#div_supplier_list").on("click", "input", function() {
            if( $(this).parent() && $(this).parent().parent() && $(this).parent().parent().attr("id") === "div_supplier_list" )
            {
                var s_list = get_supplier_list();
                for (var counter = 0; counter < s_list.length; counter++)
                {
                    var sup_info = s_list[counter];
                    if ( $(this).attr("id") === sup_info['supplier_id'] )
                    {
                        update_fields_selected_supplier(sup_info);
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
        $("#button_search_supplier").on("click", function() {
            if ($("#dropdown_search_supplier")[0].selectedIndex == 0)
            {
                alert("Please select search criteria.");
                return false;
            }
            else if ($("#input_search_supplier").val().length == 0)
            {
                alert("Please assign value of search criteria");
                return false;
            }
            $.ajax({
                type: "POST",
                url: '<?php echo base_url(); ?>' + "search/search_supplier_purchase_order",
                data: {
                    search_category_name: $("#dropdown_search_supplier").val(),
                    search_category_value: $("#input_search_supplier").val()
                },
                success: function(data) {
                    var sup_list = JSON.parse(data);
                    set_supplier_list(sup_list);
                    var current_temp_html_supplier = '';
                    for (var counter = 0; counter < sup_list.length; counter++)
                    {
                        var sup_info = sup_list[counter];
                        current_temp_html_supplier = current_temp_html_supplier + '<span id="span_supplier_info" class="span12 sales_view_block" style="">';
                        current_temp_html_supplier = current_temp_html_supplier + '<input id="' + sup_info['supplier_id'] + '" class="fl" type="text" value="' + sup_info['phone'] + '"/>';
                        current_temp_html_supplier = current_temp_html_supplier + '<input id="' + sup_info['supplier_id'] + '" class="fl" type="text" value="' + sup_info['company'] + '"/>';
                        current_temp_html_supplier = current_temp_html_supplier + '<span class="span10 view sales_view fl" style="">';
                        current_temp_html_supplier = current_temp_html_supplier + '<a target="_blank" class="view" href="<?php echo base_url(); ?>user/show_supplier/' + sup_info['isupplier_id'] + '">view</a>';
                        current_temp_html_supplier = current_temp_html_supplier + '</span>';
                        current_temp_html_supplier = current_temp_html_supplier + '</span>';                        
                    }
                    $("#div_supplier_list").html(current_temp_html_supplier);
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
        $("#button_add_supplier").on("click", function() {
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
            else if ($("#input_company").val().length == 0)
            {
                alert("Company is required.");
                return;
            }
            $.ajax({
                type: "POST",
                url: '<?php echo base_url(); ?>' + "user/create_supplier_purchase_order",
                data: {
                    first_name: $("#input_first_name").val(),
                    last_name: $("#input_last_name").val(),
                    phone_no: $("#input_phone_no").val(),
                    company: $("#input_company").val()

                },
                success: function(data) {
                    var response = JSON.parse(data);
                    if (response['status'] === '1')
                    {
                        var s_list = get_supplier_list();
                        s_list[s_list.length] = response['supplier_info'];
                        set_supplier_list(s_list);
                        alert('New supplier is added successfully.');
                        var supplier_info = response['supplier_info'];
                        
                        var current_temp_html_supplier = $("#div_supplier_list").html();                        
                        current_temp_html_supplier = current_temp_html_supplier + '<span id="span_customer_info" class="span12 sales_view_block" style="">';
                        current_temp_html_supplier = current_temp_html_supplier + '<input id="' + supplier_info['supplier_id'] + '" class="fl" type="text" value="' + supplier_info['phone'] + '"/>';
                        current_temp_html_supplier = current_temp_html_supplier + '<input id="' + supplier_info['supplier_id'] + '" class="fl" type="text" value="' + supplier_info['company'] + '"/>';
                        current_temp_html_supplier = current_temp_html_supplier + '<span class="span10 view sales_view fl" style="">';
                        current_temp_html_supplier = current_temp_html_supplier + '<a target="_blank" class="view" href="<?php echo base_url(); ?>user/show_supplier/' + supplier_info['supplier_id'] + '">view</a>';
                        current_temp_html_supplier = current_temp_html_supplier + '</span>';
                        current_temp_html_supplier = current_temp_html_supplier + '</span>';
                        $("#div_supplier_list").html(current_temp_html_supplier);                        
                        update_fields_selected_supplier(supplier_info);
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
            var product_id = '';
            var product_quantity = 1;
            var product_buy_price = 100;
            $("input", $(this).parent()).each(function(){
                if ($(this).attr("name") === "quantity" )
                {
                    if ( $(this).val() === '' || $(this).val() <= 0 || !isNumber($(this).val()) )
                    {
                        $(this).val('1');
                        alert("Invalid quantity.");
                        return false;
                    }
                    else if ($(this).attr("id") > 0 )
                    {
                        product_id = $(this).attr("id");
                        $(this).attr('value', $(this).val());
                        product_quantity = $(this).val();
                    }
                }
                if ($(this).attr("name") === "price" )
                {
                    if ( $(this).val() === '' || $(this).val() <= 0 || !isNumber($(this).val()) )
                    {
                        $(this).val('100');
                        alert("Invalid price.");
                        return false;
                    }
                    else if ($(this).attr("id") > 0 )
                    {
                        product_id = $(this).attr("id");
                        $(this).attr('value', $(this).val());
                        product_buy_price = $(this).val();
                    }
                }
                if ($(this).attr("name") === "product_buy_price" )
                {
                    $(this).attr('value', product_quantity*product_buy_price );
                    $(this).val( product_quantity*product_buy_price );                    
                }
            });
            var total_purchase_price = 0;
            $("input", "#div_selected_product_list").each(function(){
                if ($(this).attr("name") === "product_buy_price" )
                {
                    total_purchase_price = +total_purchase_price + +$(this).val();  
                }
            });
            $("#total_purchase_price").val( total_purchase_price );  
            
        });
        
        $("#save_purchase_order").on("click", function() {
            //validation checking of purchase order
            //checking whether supplier is selected or not
            if( $("#input_add_purchase_supplier_id").val().length === 0 || $("#input_add_purchase_supplier_id").val() < 0)
            {
                alert('Please select a supplier');
                return;
            }
            //checking whether purchase order no is assigned or not
            if( $("#purchase_order_no").val().length === 0)
            {
                alert('Please assign Order #');
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
            var total_purchase_price = 0;
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
                    if ($(this).attr("name") === "price" )
                    {
                        product_info.setUnitPrice( $(this).attr("value") );
                    }
                    if ($(this).attr("name") === "product_buy_price" )
                    {
                        product_info.setSubTotal( $(this).attr("value") );
                        total_purchase_price = +total_purchase_price + +$(this).attr("value");
                    }
                });
                product_list[product_list_counter++] = product_info;
            });
            if( total_purchase_price !== +$("#total_purchase_price").val() )
            {
                alert('Calculation error. Please try again.');
                return;
            }
            var purchase_info = new Purchase();
            purchase_info.setOrderNo( $("#purchase_order_no").val() );
            purchase_info.setSupplierId( $("#input_add_purchase_supplier_id").val() );
            purchase_info.setRemarks( $("#purchase_remarks").val() );
            purchase_info.setTotal($("#total_purchase_price").val());
            $.ajax({
                type: "POST",
                url: '<?php echo base_url(); ?>' + "purchase/add_purchase",
                data: {
                    product_list: product_list,
                    purchase_info: purchase_info
                },
                success: function(data) {
                    var response = JSON.parse(data);
                    if (response['status'] === '0')
                    {
                        alert(response['message']);
                    }
                    else if (response['status'] === '1')
                    {
                        alert('Purchase order is executed successfully.');
                        $("#div_selected_product_list").html('');
                        $("#input_add_purchase_supplier_id").val('');
                        $("#input_add_purchase_supplier").val('');
                        $("#input_add_purchase_company").val('');
                        $("#input_add_purchase_phone").val('');
                        $("#purchase_order_no").val('');
                        $("#purchase_remarks").val('');
                        $("#total_purchase_price").val('');
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

<h2>Purchase Order</h2>
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
				
                <div class="clr"> 
                    <span class="fl">1</span>
                    <span class="fr">2</span>                    
                </div>
                <div class="clr"> 
                    <span class="fl">3</span>
                    <span class="fr">4</span>                    
                </div>
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
                        <span class="fl">Supplier</span>
                        <span class="fr" style="margin-left:6px;">
                            <input id="input_add_purchase_supplier_id" name="input_add_purchase_supplier_id" type="hidden" />
                            <input id="input_add_purchase_supplier" style="width:96% !important;" type="text" />
                        </span>
                    </div>
                    <div class="dropdown-menu cust_popup" style="width:300%; padding: 15px; padding-bottom: 15px;">
                        <div class="clr search_details" style="width:auto;">
                            <div style="width:100%;" class="details hundrd span9">
                                <div style="width:auto;" class="clr product_details product_details12">
                                    <div class="clr span12 sales_view_block">
                                        <div class="span4 fl"><h3>Phone</h3></div>
                                        <div class="span4 fl"><h3>Company</h3></div>
                                        <div class="span4 fl"><h3>Details</h3></div>
                                    </div>
                                    <div id="div_supplier_list" class="clr span12 sales_view_block">										
                                            <?php
                                                    foreach ($supplier_list_array as $key => $supplier) {
                                            ?>
                                            <span id="span_customer_info" class="span12 sales_view_block" style="">
                                                    <input id="<?php echo $supplier['supplier_id']; ?>" class="fl" type="text" value="<?php echo $supplier['phone']; ?>"/>
                                                    <input id="<?php echo $supplier['supplier_id']; ?>" class="snd_raw fl" type="text" value="<?php echo $supplier['company']; ?>"/>
                                                    <span class="span10 view sales_view fl" style=""><a target="_blank" class="view" href="<?php echo base_url()."user/show_supplier/" . $supplier['supplier_id']; ?>">view</a></span>
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
                                                    <?php echo form_dropdown('dropdown_search_supplier', $supplier_search_category, '0', 'id="dropdown_search_supplier"'); ?>                                                    
                                                </span>
                                            </div>                                                                                      
                                            <p class="clr">&nbsp;</p>
                                        </div>
                                    </div>
                                    <div class="thirty_percnt customer1 san3 refresh" style="width:auto;">                                        
                                        <input id="input_search_supplier" name="input_search_supplier" style="width:auto;" class="clr" type="text" />
                                        <button id="button_search_supplier" name="button_search_supplier" class="btn btn-success fr">Search </button>
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
                                            <span class="fl">Company</span>
                                            <span class="fr">
                                                <input id="input_company" name="input_company" type="text" />
                                            </span>
                                        </div>
                                        <div class="clr fr">
                                            <button id="button_add_supplier" name="button_add_supplier" class="btn btn-success">Submit </button>
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
                    <span class="fr"><input id="input_add_purchase_phone" name="input_add_purchase_phone" type="text" /></span>
                </div>
                <div class="clr">
                    <span class="fl">Company</span>
                    <span class="fr"><input id="input_add_purchase_company" name="input_add_purchase_company" type="text" /></span>
                </div>
                <div class="clr">
                    <span class="fl">Address</span>
                    <span class="fr">
                        <Textarea id="textarea_add_sale_address" name="textarea_add_purchase_address"></textarea>
                    </span>
                </div>
                <p class="clr">&nbsp;</p>
                <div class="clr dropdown">                     
                    <div style ="width:250px;"class="dropdown-toggle" data-toggle="dropdown">
                        <span class="fl">Product</span>
                        <span class="fr" style="margin-left:6px;">
                            <input id="input_add_purchase_supplier" style="width:96% !important;" type="text" />
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
                                        <input id="input_search_product" name="input_search_product" style="width:auto;" class="clr" type="text" />
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
                                                <input id="input_product_name" name="input_product_name" type="text" />
                                            </span>
                                        </div>
                                        <div class="clr">
                                            <span class="fl">Product Code</span>
                                            <span class="fr">
                                                <input id="input_product_code" name="input_product_code" type="text" />
                                            </span>
                                        </div>
                                        <div class="clr">
                                            <span class="fl">Unit Price</span>
                                            <span class="fr">
                                                <input id="input_unit_price" name="input_unit_price" type="text" />
                                            </span>
                                        </div>
                                        <div class="clr fr">
                                            <button id="button_add_product" name="button_add_product" class="btn btn-success">Submit </button>
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
                   <input id="purchase_order_no" name="purchase_order_no" type="text" />
               </span>
            </div>
            <div class="clr">
               <span class="fl">Date</span>
               <span class="fr">
                   <input id="input_date_add_purchase"/>
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
         <div id="div_selected_product_name_list">
            <h3>Product Name</h3>
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
                  <textarea id="purchase_remarks" name="purchase_remarks"></textarea>
                  </span>										
               </div>
            </div>
            <p class="clr">&nbsp;</p>
            <div class="block block3">
               <div class="clr ">
                  <span class="fl">Total</span>
                  <span class="fr">
                      <input readonly="true" id="total_purchase_price" name="total_purchase_price"></input>
                  </span>										
               </div>
            </div>
            <p class="clr">&nbsp;</p>
            <div class="block block2">
               <div class="clr ">
                  <span class="fl">&nbsp;</span>
                  <span class="fr">
                  <input id="save_purchase_order" name="save_purchase_order" type="submit" value="Save"></input>
                  </span>										
               </div>
            </div>
         </div>
         <p class="clr">&nbsp;</p>
   </div>
   <p class="clr">&nbsp;</p>
</div>