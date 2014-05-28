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
                    if (data['status'] === '1')
                    {
                        var p_list = get_product_list();
                        p_list[p_list.length] = data['product_info'];
                        set_product_list(p_list);
                        alert('New product is added successfully.');
                        var product_info = data['product_info'];
                        $("#tbody_product_list").html($("#tbody_product_list").html() + tmpl("tmpl_product_list", product_info));
                        append_selected_product(product_info);
                        $('#modal_select_product').modal('hide');
                    }
                    else
                    {
                        alert('Error while creating product.');
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
                    $("#tbody_product_list").html(tmpl("tmpl_product_list", data));
                }
            });
        });
        $("#tbody_product_list").on("click", "td", function()
        {
            var p_list = get_product_list();
            for (var counter = 0; counter < p_list.length; counter++)
            {
                var prod_info = p_list[counter];
                if ($(this).attr("id") === prod_info['id'])
                {
                    append_selected_product(prod_info);
                    $('div[class="clr dropdown open"]').removeClass('open');
                    $('#modal_select_product').modal('hide');
                    return;
                }
            }

        });

        $("#button_add_select_product").on("click", function() {
            var selected_array = Array();
            $("#tbody_product_list tr").each(function() {
                $("td:first input:checkbox", $(this)).each(function() {

                    if (this.checked == true)
                    {
                        selected_array.push(this.id);
                    }
                });
            });
            var p_list = get_product_list();
            for (var counter = 0; counter < p_list.length; counter++)
            {
                var prod_info = p_list[counter];
                for (var i = 0; i < selected_array.length; i++) {
                    if (selected_array[i] === prod_info['id'])
                    {
                        append_selected_product(prod_info);
                    }
                }
            }
            $('div[class="clr dropdown open"]').removeClass('open');
            $('#modal_select_product').modal('hide');
        });

    });
</script>
<script type="text/x-tmpl" id="tmpl_product_list">
    {% var i=0, product_info = ((o instanceof Array) ? o[i++] : o); %}
    {% while(product_info){ %}
    <tr>
    <td><input id="<?php echo '{%= product_info.id%}'; ?>" name="checkbox[]" class="" type="checkbox" /></td>
    <td id="<?php echo '{%= product_info.id%}'; ?>"><?php echo '{%= product_info.name%}'; ?></td>
    <td><a target="_blank" href="<?php echo base_url() . "product/show_product/" . '{%= product_info.id%}'; ?>">view</a></td>
    </tr>
    {% product_info = ((o instanceof Array) ? o[i++] : null); %}
    {% } %}
</script>

<div class="modal fade" id="modal_select_product" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Select Product</h4>
            </div>
            <div class="modal-body">
                <div class ="row col-md-offset-1">
                    <div class="row col-md-11">
                        <div class="row table-responsive pre-scrollable">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Check box</th>
                                        <th>Name</th>
                                        <th>Details</th>
                                    </tr>
                                </thead>
                                <tbody id="tbody_product_list">
                                    <?php
                                    foreach ($product_list_array as $key => $product) {
                                        ?>
                                        <tr>
                                            <td><input id="<?php echo $product['id'] ?>" name="checkbox[]" class="" type="checkbox" /></td>
                                            <td id="<?php echo $product['id'] ?>"><?php echo $product['name'] ?></td>
                                            <td><a target="_blank" href="<?php echo base_url() . "product/show_product/" . $product['id']; ?>">view</a></td>
                                        </tr>
                                        <?php
                                    }
                                    ?>
                                </tbody>
                            </table>                            
                        </div>
                        <div class ="row col-md-3 pull-right top-bottom-padding form-group">
                            <?php echo form_button(array('name' => 'button_add_select_product', 'class' => 'form-control btn btn-success', 'id' => 'button_add_select_product', 'content' => 'Add')); ?>
                        </div>
                    </div>
                    <div class ="row col-md-11 top-bottom-padding">
                        <div class ="col-md-3">
                            <span class="" style="vertical-align: top; font-size: 24px; line-height: 12px;">Search</span>
                        </div>
                        <div class="col-md-9">
                            <div class="col-md-6">
                                <?php echo form_dropdown('dropdown_search_product', $product_search_category, '0', 'id="dropdown_search_product"'); ?>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <?php echo form_input(array('name' => 'input_search_product', 'id' => 'input_search_product', 'class' => 'form-control')); ?>
                                </div>
                                <div class="row">
                                    <?php echo form_button(array('name' => 'button_search_product', 'class' => 'form-control btn btn-success', 'id' => 'button_search_product', 'content' => 'Search')); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class ="row col-md-11 top-bottom-padding">
                        <div class ="row col-md-4">
                            <span class="" style="vertical-align: top; font-size: 24px; line-height: 12px;">
                                Add New
                            </span>
                        </div>
                        <div class="row col-md-8">
                            <div class="form-group">
                                <label class="col-md-5 control-label requiredField">
                                    Product Name
                                </label>
                                <div class ="col-md-7">
                                    <input name="product_name" class="form-control" />
                                </div> 
                            </div>
                            <div class="form-group">
                                <label class="col-md-5 control-label requiredField">
                                    Product Unit
                                </label>
                                <div class ="col-md-7">
                                    <?php echo form_dropdown('dropdown_product_unit', $product_search_category, '0', 'id="dropdown_product_unit"'); ?>
                                </div> 
                            </div>
                            <div class="form-group">
                                <label class="col-md-5 control-label requiredField">
                                    New Unit
                                </label>
                                <div class ="col-md-7">
                                    <div class="row">
                                        <div class ="col-md-12">
                                            <?php echo form_input(array('name' => 'input_search_product', 'id' => 'input_search_product', 'class' => 'form-control')); ?>
                                        </div>
                                        <div class ="col-md-12">
                                            <button class="form-control btn btn-success">Create</button>
                                        </div>
                                    </div>
                                </div> 
                            </div>
                        </div>
                        <div class="col-md-3 pull-right">
                            <button class="form-control btn btn-success">Add</button>
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



