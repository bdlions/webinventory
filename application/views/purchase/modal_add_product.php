<script type="text/javascript">
    $(function() {
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
                        current_temp_html_product = current_temp_html_product + '<div class ="row" id ="span_product_info"><div class ="col-md-4 col-md-offset-1" id="div_product_list_id">';
                        current_temp_html_product = current_temp_html_product + '<input id="' + product_info['id'] + '" class="form-control" type="text" value="' + product_info['name'] + '"/></div><div class ="col-md-4"  id="div_product_list_id">';
                        current_temp_html_product = current_temp_html_product + '<input id="' + product_info['id'] + '" class="form-control" type="text" value="' + product_info['code'] + '"/></div><div class ="col-md-3">';
                        current_temp_html_product = current_temp_html_product + '<a target="_blank" class="view" href="<?php echo base_url(); ?>product/show_product/' + product_info['id'] + '">view</a>';
                        current_temp_html_product = current_temp_html_product + '</div>';
                        current_temp_html_product = current_temp_html_product + '</div>';
                        $("#div_product_list").html(current_temp_html_product);
                        append_selected_product(product_info);
                        $('#modal_add_product').modal('hide');
                    }
                }

            });
        });

        $("#div_product_list #span_product_info #div_product_list_id").on("click", "input", function() {

            if ($(this).parent() && $(this).parent().parent() && $(this).parent().parent().attr("id") === "span_product_info")
            {
                var p_list = get_product_list();
                for (var counter = 0; counter < p_list.length; counter++)
                {
                    var prod_info = p_list[counter];
                    if ($(this).attr("id") === prod_info['id'])
                    {
                        append_selected_product(prod_info);
                        $('div[class="clr dropdown open"]').removeClass('open');
                        $('#modal_add_product').modal('hide');
                        return;
                    }
                }
            }
        });
    });

</script>
<div class ="row modal" id="modal_add_product">
    <div class ="col-md-3"></div>
    <div class ="col-md-6 modal-style form-background">
        <div class ="row">
            <div class ="col-md-4 col-md-offset-1">
                <h3>Product Name</h3>
            </div>
            <div class ="col-md-4">
                <h3>Product Code</h3>
            </div>
            <div class ="col-md-3">
                <h3>Details</h3>
            </div>
        </div>
        <div class ="row" id="div_product_list">
            <?php foreach ($product_list_array as $key => $product) { ?>
                <div class ="row" id ="span_product_info">
                    <div class ="col-md-4 col-md-offset-1" id="div_product_list_id">
                        <?php echo form_input(array('value' => $product['name'], 'id' => $product['id'], 'class' => 'form-control')); ?>
                    </div>
                    <div class ="col-md-4"  id="div_product_list_id">
                        <?php echo form_input(array('value' => $product['code'], 'id' => $product['id'], 'class' => 'form-control')); ?>            
                    </div>
                    <div class ="col-md-3">
                        <a target="_blank" href="<?php echo base_url() . "product/show_product/" . $product['id']; ?>">view</a>
                    </div>
                </div>
            <?php } ?>  
        </div>
        <div class ="row margin-top-bottom">
            <div class ="col-md-4">
                <h3>Search</h3>
            </div>
            <div class ="col-md-4">
                <?php echo form_dropdown('customer_search', $product_search_category, '0', "id='dropdown_search_customer' class='form-control'"); ?>                
            </div>
            <div class ="col-md-4">
                <?php echo form_input(array('name' => 'input_search_customer', 'id' => 'input_search_customer', 'class' => 'form-control')); ?>
                <div class ="row">
                    <div class ="col-md-4">
                        <?php echo form_button(array('name' => 'existing_customer_search', 'id' => 'existing_customer_search', 'content' => 'Search')); ?>
                    </div>
                </div>
            </div>

        </div>

        <div class ="row margin-top-bottom">
            <div class ="col-md-5">
                <h3>Add New</h3>
            </div>
            <div class ="col-md-7">
                <div class="form-horizontal">
                    <div class="row">
                        <div class ="col-md-12"> 
                            <div class="form-group">
                                <label for="input_product_name" class="col-md-4 control-label requiredField">
                                    Product Name
                                </label>
                                <div class ="col-md-6">
                                    <?php echo form_input(array('name' => 'input_product_name', 'id' => 'input_product_name', 'class' => 'form-control')); ?>
                                </div> 
                            </div>

                            <div class="form-group">
                                <label for="input_product_code" class="col-md-4 control-label requiredField">
                                    Product Code
                                </label>
                                <div class ="col-md-6">
                                    <?php echo form_input(array('name' => 'input_product_code', 'id' => 'input_product_code', 'class' => 'form-control')); ?>
                                </div> 
                            </div>


                            <div class="form-group">
                                <label for="input_unit_price" class="col-md-4 control-label requiredField">
                                    Unit Price
                                </label>
                                <div class ="col-md-6">
                                    <?php echo form_input(array('name' => 'input_unit_price', 'id' => 'input_unit_price', 'class' => 'form-control')); ?>
                                </div> 
                            </div>


                            <div class="form-group">
                                <label for="button_add_product" class="col-md-4 control-label requiredField">
                                </label>
                                <div class ="col-md-6">
                                    <?php echo form_button(array('name' => 'button_add_product', 'id' => 'button_add_product', 'content' => 'Submit')); ?>
                                </div> 
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
