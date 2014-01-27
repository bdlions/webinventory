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
        current_temp_product_html = current_temp_product_html + '<div class="row">';
        current_temp_product_html = current_temp_product_html + '<input class="col-md-3" readonly="true" type="text" value="' + prod_info['name'] + '"/>';
        current_temp_product_html = current_temp_product_html + '<input class="col-md-3" id="' + prod_info['id'] + '" name="quantity" type="text" value="1"/>';
        current_temp_product_html = current_temp_product_html + '<input class="col-md-3" id="' + prod_info['id'] + '" name="price" type="text" value="100"/>';
        current_temp_product_html = current_temp_product_html + '<input class="col-md-3" name="product_buy_price" readonly="true" type="text" value="100"/>';
        current_temp_product_html = current_temp_product_html + '</div>';
        $("#div_selected_product_list").html(current_temp_product_html);

        var total_purchase_price = 0;
        $("input", "#div_selected_product_list").each(function() {
            if ($(this).attr("name") === "product_buy_price")
            {
                total_purchase_price = +total_purchase_price + +$(this).val();
            }
        });
        $("#total_purchase_price").val(total_purchase_price);
    }

    function update_fields_selected_supplier(sup_info)
    {
        $("#input_add_purchase_supplier_id").val(sup_info['supplier_id']);
        $("#input_add_purchase_supplier").val(sup_info['first_name']+' '+sup_info['last_name']);
        $("#input_add_purchase_company").val(sup_info['company']);
        $("#input_add_purchase_phone").val(sup_info['phone']);
    }

    function isNumber(n) {
        return !isNaN(parseFloat(n)) && isFinite(n);
    }
</script>

<script type="text/javascript">
    $(function() {
        $("#button_add_product").on("click", function() {
            if ($("#input_product_name").val().length == 0)
            {
                alert("Product Name is required.");
                return;
            }
            set_modal_confirmation_category_id(get_modal_confirmation_add_product_category_id());
            $('#myModal').modal('show');
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
            set_modal_confirmation_category_id(get_modal_confirmation_add_supplier_category_id());
            $('#myModal').modal('show');
        });
        $("#button_save_purchase_order").on("click", function() {
            //validation checking of purchase order
            //checking whether supplier is selected or not
            if ($("#input_add_purchase_supplier_id").val().length === 0 || $("#input_add_purchase_supplier_id").val() < 0)
            {
                alert('Please select a supplier');
                return;
            }
            //checking whether purchase order no is assigned or not
            if ($("#purchase_order_no").val().length === 0)
            {
                alert('Please assign Lot #');
                return;
            }
            //checking whether at least one product is selected or not
            var selected_product_counter = 0;
            $("div", "#div_selected_product_list").each(function() {
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
            set_modal_confirmation_category_id(get_modal_confirmation_save_purchase_order_category_id());
            $('#myModal').modal('show');
        });
        $("#modal_button_confirm").on("click", function() {
            if (get_modal_confirmation_category_id() === get_modal_confirmation_add_product_category_id())
            {
                $.ajax({
                    type: "POST",
                    url: '<?php echo base_url(); ?>' + "product/create_product_purchase_order",
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
            }
            else if (get_modal_confirmation_category_id() === get_modal_confirmation_add_supplier_category_id())
            {
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
            }
            else if( get_modal_confirmation_category_id() === get_modal_confirmation_save_purchase_order_category_id() )
            {
                var total_purchase_price = 0;
                var product_list = new Array();
                var product_list_counter = 0;
                $("div", "#div_selected_product_list").each(function() {
                    var product_info = new Product();
                    $("input", $(this)).each(function() {
                        if ($(this).attr("name") === "quantity")
                        {
                            product_info.setProductId($(this).attr("id"));
                            product_info.setQuantity($(this).attr("value"));
                            product_info.setPurchaseOrderNo($("#purchase_order_no").val());
                        }
                        if ($(this).attr("name") === "price")
                        {
                            product_info.setUnitPrice($(this).attr("value"));
                        }
                        if ($(this).attr("name") === "product_buy_price")
                        {
                            product_info.setSubTotal($(this).attr("value"));
                            total_purchase_price = +total_purchase_price + +$(this).attr("value");
                        }
                    });
                    product_list[product_list_counter++] = product_info;
                });
                if (total_purchase_price !== +$("#total_purchase_price").val())
                {
                    alert('Calculation error. Please try again.');
                    return;
                }
                var purchase_info = new Purchase();
                purchase_info.setOrderNo($("#purchase_order_no").val());
                purchase_info.setSupplierId($("#input_add_purchase_supplier_id").val());
                purchase_info.setRemarks($("#purchase_remarks").val());
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
            }
            $('#myModal').modal('hide');
        });
        
        $("#input_date_add_purchase").datepicker();
        $("#div_supplier_list").on("click", "input", function() {
            if ($(this).parent() && $(this).parent().parent() && $(this).parent().parent().attr("id") === "div_supplier_list")
            {
                var s_list = get_supplier_list();
                for (var counter = 0; counter < s_list.length; counter++)
                {
                    var sup_info = s_list[counter];
                    if ($(this).attr("id") === sup_info['supplier_id'])
                    {
                        update_fields_selected_supplier(sup_info);
                        $('div[class="clr dropdown open"]').removeClass('open');
                        return;
                    }
                }
            }
        });
        $("#div_product_list").on("click", "input", function() {
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
                        current_temp_html_product = current_temp_html_product + '<span class="span10 view sales_view fl" style="">';
                        current_temp_html_product = current_temp_html_product + '<a target="_blank" class="view" href="<?php echo base_url(); ?>user/show_customer/' + prod_info['id'] + '">view</a>';
                        current_temp_html_product = current_temp_html_product + '</span>';
                        current_temp_html_product = current_temp_html_product + '</span>';
                    }
                    $("#div_product_list").html(current_temp_html_product);
                }
            });
        });

        $("#div_selected_product_list").on("change", "input", function() {
            var product_id = '';
            var product_quantity = 1;
            var product_buy_price = 100;
            $("input", $(this).parent()).each(function() {
                if ($(this).attr("name") === "quantity")
                {
                    if ($(this).val() === '' || $(this).val() <= 0 || !isNumber($(this).val()))
                    {
                        $(this).val('1');
                        alert("Invalid quantity.");
                        return false;
                    }
                    else if ($(this).attr("id") > 0)
                    {
                        product_id = $(this).attr("id");
                        $(this).attr('value', $(this).val());
                        product_quantity = $(this).val();
                    }
                }
                if ($(this).attr("name") === "price")
                {
                    if ($(this).val() === '' || $(this).val() <= 0 || !isNumber($(this).val()))
                    {
                        $(this).val('100');
                        alert("Invalid price.");
                        return false;
                    }
                    else if ($(this).attr("id") > 0)
                    {
                        product_id = $(this).attr("id");
                        $(this).attr('value', $(this).val());
                        product_buy_price = $(this).val();
                    }
                }
                if ($(this).attr("name") === "product_buy_price")
                {
                    $(this).attr('value', product_quantity * product_buy_price);
                    $(this).val(product_quantity * product_buy_price);
                }
            });
            var total_purchase_price = 0;
            $("input", "#div_selected_product_list").each(function() {
                if ($(this).attr("name") === "product_buy_price")
                {
                    total_purchase_price = +total_purchase_price + +$(this).val();
                }
            });
            $("#total_purchase_price").val(total_purchase_price);

        });
    });
</script>
<script type="text/javascript">
    $(function() {
        $('.dropdown-toggle').dropdown();
        $(".dropdown-menu").on("click", function(e) {
            e.stopPropagation();
        });
        $(".btn-default").on("click", function(e) {
            $('#myModal').modal('hide');
            e.stopPropagation();
        });
    });
</script>

<h6>Purchase Order</h6>
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
                Supplier
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
                foreach ($supplier_list_array as $key => $supplier) {
                    ?>
                    <div class ="row"><div class ="col-md-offset-2 col-md-11">
                            <?php echo $supplier['phone']; ?>
                        </div></div>

                    <?php
                }
                ?>
            </div>
            <div class="col-md-6">
                <div class ="row"><div class ="col-md-offset-2 col-md-11"><h3><u>Status</u></h3></div></div>
                <?php
                foreach ($supplier_list_array as $key => $supplier) {
                    ?>             
                    <div class ="row"><div class ="col-md-offset-2 col-md-11">
                            <?php echo $supplier['company']; ?>   
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
                    <label for="input_add_purchase_supplier" class="col-md-3 control-label requiredField">
                        Supplier
                    </label> 
                    <div class ="col-md-8">
                        <?php echo form_input(array('name' => 'input_add_purchase_supplier_id', 'id' => 'input_add_purchase_supplier_id', 'class' => 'form-control', 'type' => 'hidden')); ?>
                        <?php echo form_input(array('name' => 'input_add_purchase_supplier', 'id' => 'input_add_purchase_supplier', 'class' => 'form-control', 'data-toggle' => 'modal', 'data-target' => '#modal_add_supplier')); ?>
                    </div> 
                </div>
                <div class="form-group">
                    <label for="input_add_purchase_phone" class="col-md-3 control-label requiredField">
                        Phone No.
                    </label>
                    <div class ="col-md-8">
                        <?php echo form_input(array('name' => 'input_add_purchase_phone', 'id' => 'input_add_purchase_phone', 'class' => 'form-control')); ?>
                    </div> 
                </div>
                <div class="form-group">
                    <label for="input_add_purchase_company" class="col-md-3 control-label requiredField">
                        Company
                    </label>
                    <div class ="col-md-8">
                        <?php echo form_input(array('name' => 'input_add_purchase_company', 'id' => 'input_add_purchase_company', 'class' => 'form-control')); ?>
                    </div> 
                </div>
                <div class="form-group">
                    <label for="textarea_add_sale_address" class="col-md-3 control-label requiredField">
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
                        <?php echo form_input(array('name' => 'input_add_purchase_supplier', 'id' => 'input_add_purchase_supplier', 'class' => 'form-control', 'data-toggle' => 'modal', 'data-target' => '#modal_add_product')); ?>
                    </div> 
                </div>
            </div>
            <div class ="col-md-5 form-horizontal margin-top-bottom">
                <div class="form-group">
                    <label for="purchase_order_no" class="col-md-4 control-label requiredField">
                        Order No.
                    </label>
                    <div class ="col-md-8">
                        <?php echo form_input(array('name' => 'purchase_order_no', 'id' => 'purchase_order_no', 'class' => 'form-control')); ?>
                    </div> 
                </div>
                <div class="form-group">
                    <label for="input_date_add_purchase" class="col-md-4 control-label requiredField">
                        Date
                    </label>
                    <div class ="col-md-8">
                        <?php echo form_input(array('name' => 'input_date_add_purchase', 'id' => 'input_date_add_purchase', 'class' => 'form-control')); ?>
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
            </div>
        </div>

        <div class ="row boxshad">
            <div class ="row">
                <div class="col-md-12">
                    <div class ="col-md-3">
                        Product Name
                    </div>
                    <div class ="col-md-3">
                        Quantity
                    </div>
                    <div class ="col-md-3">
                        Unit Price
                    </div>
                    <div class ="col-md-3">
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
                    <label for="remarks" class="col-md-2 control-label requiredField">
                        Remarks
                    </label>
                    <div class ="col-md-3 col-md-offset-5">
                        <?php echo form_textarea(array('name' => 'remarks', 'id' => 'remarks', 'class' => 'form-control', 'rows' => '5', 'cols' => '4')); ?>

                    </div> 
                </div>
                <div class="form-group">
                    <label for="total_purchase_price" class="col-md-2 control-label requiredField">
                        Total
                    </label>
                    <div class ="col-md-3 col-md-offset-5">
                        <?php echo form_input(array('name' => 'total_purchase_price', 'id' => 'total_purchase_price', 'class' => 'form-control')); ?>
                    </div> 
                </div>
                <div class="form-group">
                    <label for="save" class="col-md-2 control-label requiredField">

                    </label>
                    <div class ="col-md-3 col-md-offset-5">
                        <?php echo form_button(array('name' => 'button_save_purchase_order', 'id' => 'button_save_purchase_order', 'content' => 'Save', 'class' => 'form-control btn-success')); ?>
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
<?php $this->load->view("purchase/modal_add_supplier"); ?>
<?php $this->load->view("purchase/modal_add_product"); ?>