<script type="text/javascript">
    $(function() {
        $("#button_add_product").on("click", function() {
            if ($("#input_product_name").val().length == 0)
            {
                alert("Product Name is required.");
                return;
            }            
            $.ajax({
                dataType: 'json',
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
                        current_temp_html_product = current_temp_html_product + '<div class ="row">';
                        current_temp_html_product = current_temp_html_product + '<div class ="col-md-4 col-md-offset-1"><input class="form-control" name="' + product_info['id'] + '" id="' + product_info['id'] + '" type="text" value="' + product_info['name'] + '"/></div>';
                        current_temp_html_product = current_temp_html_product + '<div class ="col-md-3"><a target="_blank" class="view" href="<?php echo base_url(); ?>product/show_product/' + product_info['id'] + '">view</a></div>';
                        current_temp_html_product = current_temp_html_product + '</div>'; 
                        $("#div_product_list").html(current_temp_html_product);
                        append_selected_product(product_info);
                        $('#modal_add_product').modal('hide');
                    }
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
                dataType: 'json',
                type: "POST",
                url: '<?php echo base_url(); ?>' + "search/search_product_order",
                data: {
                    search_category_name: $("#dropdown_search_product").val(),
                    search_category_value: $("#input_search_product").val()
                },
                success: function(data) {
                    var prod_list = data;
                    set_product_list(prod_list);
                    var current_temp_html_product = '';
                    for (var counter = 0; counter < prod_list.length; counter++)
                    {
                        var product_info = prod_list[counter];
                        current_temp_html_product = current_temp_html_product + '<div class ="row">';
                        current_temp_html_product = current_temp_html_product + '<div class ="col-md-4 col-md-offset-1"><input class="form-control" name="' + product_info['id'] + '" id="' + product_info['id'] + '" type="text" value="' + product_info['name'] + '"/></div>';
                        current_temp_html_product = current_temp_html_product + '<div class ="col-md-3"><a target="_blank" class="view" href="<?php echo base_url(); ?>product/show_product/' + product_info['id'] + '">view</a></div>';
                        current_temp_html_product = current_temp_html_product + '</div>'; 
                    }
                    $("#div_product_list").html(current_temp_html_product);
                }
            });
        });
        $("#div_product_list").on("click", "input", function() {
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
        });
    });

</script>
<div class="modal fade" id="modal_add_product" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Select Product</h4>
            </div>
            <div class="modal-body">
                <div class ="row">
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
                            <div class ="row">
                                <div class ="col-md-4 col-md-offset-1">
                                    <?php echo form_input(array('value' => $product['name'], 'id' => $product['id'], 'class' => 'form-control')); ?>
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
                            <?php echo form_dropdown('dropdown_search_product', $product_search_category, '0', "id='dropdown_search_product' class='form-control'"); ?>                
                        </div>
                        <div class ="col-md-4">
                            <?php echo form_input(array('name' => 'input_search_product', 'id' => 'input_search_product', 'class' => 'form-control')); ?>
                            <div class ="row">
                                <div class ="col-md-12">
                                    <?php echo form_button(array('name' => 'button_search_product','class'=>'form-control btn btn-success', 'id' => 'button_search_product', 'content' => 'Search')); ?>
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
                                            <label for="button_add_product" class="col-md-4 control-label requiredField">
                                            </label>
                                            <div class ="col-md-6">
                                                <?php echo form_button(array('name' => 'button_add_product', 'class'=>'form-control btn btn-success', 'id' => 'button_add_product', 'content' => 'Submit')); ?>
                                            </div> 
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
