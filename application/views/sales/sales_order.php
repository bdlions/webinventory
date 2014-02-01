<script type="text/javascript">
    $(document).ready(function() {
        var customer_data = <?php echo json_encode($customer_list_array) ?>;
        set_customer_list(customer_data);

        var product_data = <?php echo json_encode($product_list_array) ?>;
        set_product_list(product_data);
    });
</script>
<script>
    function append_selected_product(prod_info)
    {
        var is_product_previously_selected = false;
        $("span", "#div_selected_product_list").each(function() {
            $("input", $(this)).each(function() {
                if ($(this).attr("name") === "quantity")
                {
                    if ($(this).attr("id") === prod_info['id'])
                    {
                        is_product_previously_selected = true;
                    }
                }
            });
        });
        if (is_product_previously_selected === true)
        {
            alert('The product is already selected. Please update product quantity.');
            return;
        }

        var current_temp_product_html = $("#div_selected_product_list").html();
        current_temp_product_html = current_temp_product_html + '<span>';
        current_temp_product_html = current_temp_product_html + '<input class="col-md-2" id="' + prod_info['id'] + '" name="purchase_order_no" type="text" value="1"/>';
        current_temp_product_html = current_temp_product_html + '<input class="col-md-2" name="product_name" readonly="true" type="text" value="' + prod_info['name'] + '"/>';
        current_temp_product_html = current_temp_product_html + '<input class="col-md-2" id="' + prod_info['id'] + '" name="quantity" type="text" value="1"/>';
        current_temp_product_html = current_temp_product_html + '<input class="col-md-2" id="' + prod_info['id'] + '" type="text" name="unit_price" value="' + prod_info['unit_price'] + '"/>';
        current_temp_product_html = current_temp_product_html + '<input class="col-md-2" id="' + prod_info['id'] + '" name="discount" type="text" value="0"/>';
        current_temp_product_html = current_temp_product_html + '<input class="col-md-2" name="product_sale_price" readonly="true" type="text" value="' + prod_info['unit_price'] + '"/>';
        current_temp_product_html = current_temp_product_html + '</span>';
        $("#div_selected_product_list").html(current_temp_product_html);

        var total_sale_price = 0;
        $("input", "#div_selected_product_list").each(function() {
            if ($(this).attr("name") === "product_sale_price")
            {
                total_sale_price = +total_sale_price + +$(this).val();
            }
        });
        $("#total_sale_price").val(total_sale_price);
    }

    function update_fields_selected_customer(cust_info)
    {
        $("#input_add_sale_customer_id").val(cust_info['customer_id']);
        $("#input_add_sale_customer").val(cust_info['username']);
        $("#input_add_sale_card_no").val(cust_info['card_no']);
        $("#input_add_sale_phone").val(cust_info['phone']);

        var rString = randomString(13, '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ');
        $("#sale_order_no").val(rString);
    }

    function isNumber(n) {
        return !isNaN(parseFloat(n)) && isFinite(n);
    }

    function randomString(length, chars) {
        var result = '';
        for (var i = length; i > 0; --i)
            result += chars[Math.round(Math.random() * (chars.length - 1))];
        return result;
    }
</script>

<script type="text/javascript">
    $(function() {
        /*$("#button_add_product").on("click", function() {
            if ($("#input_product_name").val().length == 0)
            {
                alert("Product Name is required.");
                return;
            }
            set_modal_confirmation_category_id(get_modal_confirmation_add_product_category_id());
            $('#myModal').modal('show');
        });*/
        /*$("#button_add_customer").on("click", function() {
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
            set_modal_confirmation_category_id(get_modal_confirmation_add_customer_category_id());
            $('#myModal').modal('show');
        });*/
        $("#save_sale_order").on("click", function() {
            //validation checking of sale order
            //checking whether customer is selected or not
            if ($("#input_add_sale_customer_id").val().length === 0 || $("#input_add_sale_customer_id").val() < 0)
            {
                alert('Please select a customer');
                return;
            }
            //checking whether sale order no is empty or not
            if ($("#sale_order_no").val().length === 0)
            {
                alert('Incorrect Order #');
                return;
            }
            //checking whether at least one product is selected or not
            var selected_product_counter = 0;
            $("span", "#div_selected_product_list").each(function() {
                $("input", $(this)).each(function() {
                    if ($(this).attr("name") === "quantity")
                    {
                        selected_product_counter++;
                    }
                });
            });
            if (selected_product_counter <= 0)
            {
                alert('Please select at least one product.');
                return;
            }
            set_modal_confirmation_category_id(get_modal_confirmation_save_sale_order_category_id());
            $('#myModal').modal('show');
        });
        $("#modal_button_confirm").on("click", function() {
            /*if (get_modal_confirmation_category_id() === get_modal_confirmation_add_product_category_id())
            {
                $.ajax({
                    type: "POST",
                    url: '<?php echo base_url(); ?>' + "product/create_product_sale_order",
                    data: {
                        product_name: $("#input_product_name").val()
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
            }*/
            /*else if (get_modal_confirmation_category_id() === get_modal_confirmation_add_customer_category_id())
            {
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
            }*/
            if (get_modal_confirmation_category_id() === get_modal_confirmation_save_sale_order_category_id())
            {
                //creating a list based on selected products
                var product_list = new Array();
                var product_list_counter = 0;
                $("span", "#div_selected_product_list").each(function() {
                    var product_info = new Product();
                    $("input", $(this)).each(function() {
                        if ($(this).attr("name") === "quantity")
                        {
                            product_info.setProductId($(this).attr("id"));
                            product_info.setQuantity($(this).attr("value"));
                        }
                        if ($(this).attr("name") === "product_name")
                        {
                            product_info.setName( $(this).attr("value") );
                        }
                        if ($(this).attr("name") === "purchase_order_no")
                        {
                            product_info.setPurchaseOrderNo($(this).attr("value"));
                        }
                        if ($(this).attr("name") === "unit_price")
                        {
                            product_info.setUnitPrice($(this).attr("value"));
                        }
                        if ($(this).attr("name") === "discount")
                        {
                            product_info.setDiscount($(this).attr("value"));
                        }
                        if ($(this).attr("name") === "product_sale_price")
                        {
                            product_info.setSubTotal($(this).attr("value"));
                        }
                    });
                    product_list[product_list_counter++] = product_info;
                });
                var sale_info = new Sale();
                sale_info.setOrderNo($("#sale_order_no").val());
                sale_info.setCustomerId($("#input_add_sale_customer_id").val());
                sale_info.setRemarks($("#sale_remarks").val());
                sale_info.setCreatedBy($("#salesman_list").val());
                $.ajax({
                    type: "POST",
                    url: '<?php echo base_url(); ?>' + "sale/add_sale",
                    data: {
                        product_list: product_list,
                        sale_info: sale_info
                    },
                    success: function(data) {
                        var response = JSON.parse(data);
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
            }
            $('#myModal').modal('hide');
        });

        $("#input_date_add_sale").datepicker();
        /*$("#div_customer_list").on("click", "input", function() {
            if ($(this).parent() && $(this).parent().parent() && $(this).parent().parent().attr("id") === "div_customer_list")
            {
                var c_list = get_customer_list();
                for (var counter = 0; counter < c_list.length; counter++)
                {
                    var cust_info = c_list[counter];
                    if ($(this).attr("id") === cust_info['customer_id'])
                    {
                        update_fields_selected_customer(cust_info);
                        $('div[class="clr dropdown open"]').removeClass('open');
                        return;
                    }
                }
            }
        });*/
        /*$("#div_product_list").on("click", "input", function() {
            if ($(this).parent() && $(this).parent().parent() && $(this).parent().parent().attr("id") === "div_product_list")
            {
                var p_list = get_product_list();
                for (var counter = 0; counter < p_list.length; counter++)
                {
                    var prod_info = p_list[counter];
                    if ($(this).attr("id") === prod_info['id'])
                    {
                        append_selected_product(prod_info);
                        $('div[class="clr dropdown open"]').removeClass('open');
                        return;
                    }
                }
            }
        });*/
        /*$("#button_search_customer").on("click", function() {
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
        });*/
        /*$("#button_search_product").on("click", function() {
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
                        current_temp_html_product = current_temp_html_product + '<span class="span10 view sales_view fl" style="">';
                        current_temp_html_product = current_temp_html_product + '<a target="_blank" class="view" href="<?php echo base_url(); ?>user/show_customer/' + prod_info['id'] + '">view</a>';
                        current_temp_html_product = current_temp_html_product + '</span>';
                        current_temp_html_product = current_temp_html_product + '</span>';
                    }
                    $("#div_product_list").html(current_temp_html_product);
                }
            });
        });*/

        $("#div_selected_product_list").on("change", "input", function() {
            var product_quantity = '';
            var product_discount = '';
            var product_unit_price = '';
            var total_product_price = '';
            $("input", $(this).parent()).each(function() {
                if ($(this).attr("name") === "purchase_order_no")
                {
                    if ($(this).val() === '')
                    {
                        $(this).val('1');
                        alert("Invalid Lot No.");
                        return false;
                    }
                    $(this).attr('value', $(this).val());
                }
                if ($(this).attr("name") === "quantity")
                {
                    if ($(this).val() === '' || $(this).val() <= 0 || !isNumber($(this).val()))
                    {
                        $(this).val('1');
                        alert("Invalid quantity.");
                        return false;
                    }
                    $(this).attr('value', $(this).val());
                    product_quantity = $(this).val();
                }
                if ($(this).attr("name") === "unit_price")
                {
                    if ($(this).val() === '' || $(this).val() < 0 || !isNumber($(this).val()))
                    {
                        $(this).val('1');
                        alert("Invalid quantity.");
                        return false;
                    }
                    $(this).attr('value', $(this).val());
                    product_unit_price = $(this).val();
                }
                if ($(this).attr("name") === "discount")
                {
                    if ($(this).val() === '' || !isNumber($(this).val()) || +$(this).val() < 0 || +$(this).val() > 100)
                    {
                        $(this).val('0');
                        alert("Invalid discount.");
                        return false;
                    }
                    $(this).attr('value', $(this).val());
                    product_discount = $(this).val();
                }
                if ($(this).attr("name") === "product_sale_price")
                {
                    total_product_price = (product_quantity * product_unit_price) - (product_quantity * product_unit_price * product_discount / 100);
                    $(this).attr('value', total_product_price);
                    $(this).val(total_product_price);
                }
            });

            var total_sale_price = 0;
            $("input", "#div_selected_product_list").each(function() {
                if ($(this).attr("name") === "product_sale_price")
                {
                    total_sale_price = +total_sale_price + +$(this).val();
                }
            });
            $("#total_sale_price").val(total_sale_price);
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

<h6>Sales Order</h6>
<div class ="row margin-top-bottom form-background">
    <div class ="col-md-3 form-horizontal">
        <h6>Search</h6>
        <div class="form-group">
            <label for="order_no" class="col-md-3 control-label requiredField">
                Order#
            </label>
            <div class ="col-md-8">
                <?php echo form_input(array('name' => 'order_no', 'id' => 'order_no', 'class' => 'form-control')); ?>
            </div> 
        </div>
        <div class="form-group">
            <label for="status" class="col-md-3 control-label requiredField">
                Status
            </label>
            <div class ="col-md-8">
                <?php echo form_dropdown('status', (array('all' => 'all', '1' => '1', '2' => '2', '3' => '3')), 3, "class='form-control'"); ?>
            </div> 
        </div>
        <div class="form-group">
            <label for="customer_search" class="col-md-3 control-label requiredField">
                Customer
            </label>
            <div class ="col-md-8">
                <?php echo form_dropdown('customer_search', (array('all' => 'all', '1' => '1', '2' => '2', '3' => '3')), 3, "class='form-control'"); ?>
            </div> 
        </div>
        <div class="form-group">
            <label for="customer_search" class="col-md-3 control-label requiredField">

            </label>
            <div class ="col-md-8">
                <?php echo form_button(array('name' => 'customer_search', 'id' => 'customer_search', 'content' => 'Search')); ?>
            </div> 
        </div> 
        <div class="row">			
            <div class="col-md-6">
                <div class ="row"><div class ="col-md-offset-2 col-md-11"><h3><u>Order#</u></h3></div></div>
                <?php
                foreach ($customer_list_array as $key => $customer) {
                    ?>
                    <div class ="row"><div class ="col-md-offset-2 col-md-11">
                            <?php echo $customer['phone']; ?>
                        </div></div>

                    <?php
                }
                ?>
            </div>
            <div class="col-md-6">
                <div class ="row"><div class ="col-md-offset-2 col-md-11"><h3><u>Status</u></h3></div></div>
                <?php
                foreach ($customer_list_array as $key => $customer) {
                    ?>               
                    <div class ="row"><div class ="col-md-offset-2 col-md-11">
                            <?php echo $customer['card_no']; ?>   
                        </div></div>
                    <?php
                }
                ?>
            </div>
        </div>
    </div>
    <div class ="col-md-8 form-horizontal">
        <div class="row">
            <div class ="col-md-7 form-horizontal margin-top-bottom">
                <div class="form-group" >
                    <label for="input_add_sale_customer" class="col-md-3 control-label requiredField">
                        Customer
                    </label> 
                    <div class ="col-md-8">
                        <?php echo form_input(array('name' => 'input_add_sale_customer_id', 'id' => 'input_add_sale_customer_id', 'class' => 'form-control', 'type' => 'hidden')); ?>
                        <?php echo form_input(array('name' => 'input_add_sale_customer', 'id' => 'input_add_sale_customer', 'class' => 'form-control', 'data-toggle' => 'modal', 'data-target' => '#modal_add_customer')); ?>
                    </div> 
                </div>
                <div class="form-group">
                    <label for="input_add_sale_phone" class="col-md-3 control-label requiredField">
                        Phone No.
                    </label>
                    <div class ="col-md-8">
                        <?php echo form_input(array('name' => 'input_add_sale_phone', 'id' => 'input_add_sale_phone', 'class' => 'form-control')); ?>
                    </div> 
                </div>
                <div class="form-group">
                    <label for="input_add_sale_card_no" class="col-md-3 control-label requiredField">
                        Card No.
                    </label>
                    <div class ="col-md-8">
                        <?php echo form_input(array('name' => 'input_add_sale_card_no', 'id' => 'input_add_sale_card_no', 'class' => 'form-control')); ?>
                    </div> 
                </div>
                <div class="form-group">
                    <label for="address" class="col-md-3 control-label requiredField">
                        Address
                    </label>
                    <div class ="col-md-8">
                        <?php echo form_textarea(array('name' => 'textarea_add_sale_address', 'id' => 'textarea_add_sale_address', 'class' => 'form-control', 'rows' => '5', 'cols' => '4')); ?>
                    </div> 
                </div>
                <div class="form-group">
                    <label for="product" class="col-md-3 control-label requiredField">
                        Product
                    </label>
                    <div class ="col-md-8">
                        <?php echo form_input(array('name' => 'input_add_sale_product', 'id' => 'input_add_sale_product', 'class' => 'form-control', 'data-toggle' => 'modal', 'data-target' => '#modal_add_product')); ?>
                    </div> 
                </div>
            </div>
            <div class ="col-md-5 form-horizontal margin-top-bottom">
                <div class="form-group">
                    <label for="sale_order_no" class="col-md-4 control-label requiredField">
                        Order No.
                    </label>
                    <div class ="col-md-8">
                        <?php echo form_input(array('name' => 'sale_order_no', 'id' => 'sale_order_no', 'class' => 'form-control')); ?>
                    </div> 
                </div>
                <div class="form-group">
                    <label for="input_date_add_sale" class="col-md-4 control-label requiredField">
                        Date
                    </label>
                    <div class ="col-md-8">
                        <?php echo form_input(array('name' => 'input_date_add_sale', 'id' => 'input_date_add_sale', 'class' => 'form-control')); ?>
                    </div> 
                </div>
                <div class="form-group">
                    <label for="status" class="col-md-4 control-label requiredField">
                        Status
                    </label>
                    <div class ="col-md-8">
                        <?php echo form_input(array('name' => 'status', 'id' => 'status', 'class' => 'form-control')); ?>
                    </div> 
                </div>
                <div class="form-group">
                    <label for="status" class="col-md-4 control-label requiredField">
                        Select Salesman
                    </label>
                    <div class ="col-md-8">
                        <?php echo form_dropdown('salesman_list', $salesman_list, $user_info['id'], 'class="form-control" id="salesman_list"'); ?>
                    </div> 
                </div>
            </div>
        </div>

        <div class ="row boxshad">
            <div class ="row">
                <div class="col-md-12">
                    <div class ="col-md-2">
                        Lot No
                    </div>
                    <div class ="col-md-2">
                        Product Name
                    </div>
                    <div class ="col-md-2">
                        Quantity
                    </div>
                    <div class ="col-md-2">
                        Unit Price
                    </div>
                    <div class ="col-md-2">
                        Discount % 
                    </div>
                    <div class ="col-md-2">
                        Sub-Total
                    </div>
                </div>
            </div>
            <div class="row">
                <div id="div_selected_product_list" class="col-md-12">										

                </div>  
            </div>
        </div>

        <div class="row margin-top-bottom">
            <div class ="col-md-12 form-horizontal">
                <div class="form-group">
                    <label for="sale_remarks" class="col-md-2 control-label requiredField">
                        Remarks
                    </label>
                    <div class ="col-md-3 col-md-offset-5">
                        <?php echo form_textarea(array('name' => 'sale_remarks', 'id' => 'sale_remarks', 'class' => 'form-control', 'rows' => '5', 'cols' => '4')); ?>

                    </div> 
                </div>
                <div class="form-group">
                    <label for="total_sale_price" class="col-md-2 control-label requiredField">
                        Total
                    </label>
                    <div class ="col-md-3 col-md-offset-5">
                        <?php echo form_input(array('name' => 'total_sale_price', 'id' => 'total_sale_price', 'class' => 'form-control')); ?>
                    </div> 
                </div>
                <div class="form-group">
                    <label for="save_sale_order" class="col-md-2 control-label requiredField">

                    </label>
                    <div class ="col-md-3 col-md-offset-5">
                        <?php echo form_button(array('name' => 'save_sale_order', 'id' => 'save_sale_order', 'content' => 'Save', 'class' => 'form-control btn-success')); ?>
                    </div> 
                </div>
            </div>
        </div>

    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h2 class="modal-title" id="myModalLabel">Confirm Message</h2>
      </div>
      <div class="modal-body">
       Do You want to proceed?
      </div>
      <div class="modal-footer">          
        <button type="button" id ="modal_button_confirm" class="btn btn-primary">Yes</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<?php $this->load->view("sales/modal_add_customer"); ?>
<?php $this->load->view("sales/modal_add_product"); ?>