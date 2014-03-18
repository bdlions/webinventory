<script type="text/javascript">
    $(function()
    {
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
                dataType: 'json',
                type: "POST",
                url: '<?php echo base_url(); ?>' + "user/create_supplier_purchase_order",
                data: {
                    first_name: $("#input_first_name").val(),
                    last_name: $("#input_last_name").val(),
                    phone_no: $("#input_phone_no").val(),
                    company: $("#input_company").val()
                },
                success: function(data) {
                    if (data['status'] === '1')
                    {
                        var s_list = get_supplier_list();
                        s_list[s_list.length] = data['supplier_info'];
                        set_supplier_list(s_list);
                        alert('New supplier is added successfully.');
                        var supplier_info = data['supplier_info'];
                        $("#tbody_supplier_list").html($("#tbody_supplier_list").html()+tmpl("tmpl_supplier_list", supplier_info));
                        update_fields_selected_supplier(supplier_info);
                        $('#modal_select_supplier').modal('hide');
                    }
                    else
                    {
                        alert('Error while creating a supplier. Try again');
                    }
                }

            });
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
                dataType: 'json',
                type: "POST",
                url: '<?php echo base_url(); ?>' + "search/search_supplier_purchase_order",
                data: {
                    search_category_name: $("#dropdown_search_supplier").val(),
                    search_category_value: $("#input_search_supplier").val()
                },
                success: function(data) {
                    $("#tbody_supplier_list").html(tmpl("tmpl_supplier_list", data));
                    set_supplier_list(data);
                }
            });
        });
        $("#tbody_supplier_list").on("click", "td", function() {
            var s_list = get_supplier_list();
            for (var counter = 0; counter < s_list.length; counter++)
            {
                var sup_info = s_list[counter];
                if ($(this).attr("id") === sup_info['supplier_id'])
                {
                    update_fields_selected_supplier(sup_info);
                    $('div[class="clr dropdown open"]').removeClass('open');
                    $('#modal_select_supplier').modal('hide');
                    return;
                }
            }
        });
        $("#button_close_modal_select_supplier").on("click", function() {
            $('#modal_select_supplier').modal('hide');
        });
    });
</script>

<div class="modal fade" id="modal_select_supplier" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Select Supplier</h4>
            </div>
            <div class="modal-body">
                <div class ="row col-md-offset-1">
                    <div class="row col-md-11">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Phone</th>
                                        <th>Company</th>
                                        <th>Details</th>
                                    </tr>
                                </thead>
                                <tbody id="tbody_supplier_list">
                                    <?php
                                    foreach ($supplier_list_array as $key => $supplier) {
                                        ?>
                                        <tr>
                                            <td id="<?php echo $supplier['supplier_id'] ?>"><?php echo $supplier['first_name'] . ' ' . $supplier['last_name'] ?></td>
                                            <td id="<?php echo $supplier['supplier_id'] ?>"><?php echo $supplier['phone'] ?></td>
                                            <td id="<?php echo $supplier['supplier_id'] ?>"><?php echo $supplier['company'] ?></td>
                                            <td><a target="_blank" href="<?php echo base_url() . "user/show_supplier/" . $supplier['supplier_id']; ?>">view</a></td>
                                        </tr>
                                        <?php
                                    }
                                    ?>
                                <script type="text/x-tmpl" id="tmpl_supplier_list">
                                    {% var i=0, supplier_info = ((o instanceof Array) ? o[i++] : o); %}
                                    {% while(supplier_info){ %}
                                    <tr>
                                    <td id="<?php echo '{%= supplier_info.supplier_id%}'; ?>"><?php echo '{%= supplier_info.first_name%}' . ' ' . '{%= supplier_info.last_name%}'; ?></td>
                                    <td id="<?php echo '{%= supplier_info.supplier_id%}'; ?>"><?php echo '{%= supplier_info.phone%}'; ?></td>
                                    <td id="<?php echo '{%= supplier_info.supplier_id%}'; ?>"><?php echo '{%= supplier_info.company%}'; ?></td>
                                    <td><a target="_blank" href="<?php echo base_url() . "user/show_supplier/" . '{%= supplier_info.supplier_id%}'; ?>">view</a></td>
                                    </tr>
                                    {% supplier_info = ((o instanceof Array) ? o[i++] : null); %}
                                    {% } %}
                                </script>
                                </tbody>
                            </table>
                        </div>
                    </div>                                        
                    <div class ="row col-md-11 top-bottom-padding">
                        <div class ="col-md-4">
                            <h3>Search</h3>
                        </div>
                        <div class ="col-md-4">
                            <?php echo form_dropdown('dropdown_search_supplier', $supplier_search_category, '0', 'id="dropdown_search_supplier"'); ?>
                        </div>
                        <div class ="col-md-4">
                            <div class="row form-group">
                                <div class="col-md-12">
                                    <?php echo form_input(array('name' => 'input_search_supplier', 'id' => 'input_search_supplier', 'class' => 'form-control')); ?>
                                </div>
                            </div>                            
                            <div class ="row form-group">
                                <div class="col-md-12">
                                    <?php echo form_button(array('name' => 'button_search_supplier', 'class' => 'form-control btn btn-success', 'id' => 'button_search_supplier', 'content' => 'Search')); ?>
                                </div>
                            </div>
                        </div>                      
                    </div>

                    <div class ="row col-md-11">
                        <div class ="col-md-5">
                            <h3>Add New</h3>
                        </div>
                        <div class ="col-md-7">
                            <div class="form-horizontal">
                                <div class="row form-group">
                                    <label for="input_first_name" class="col-md-4 control-label requiredField">
                                        First Name
                                    </label>
                                    <div class ="col-md-8">
                                        <?php echo form_input(array('name' => 'input_first_name', 'id' => 'input_first_name', 'class' => 'form-control')); ?>
                                    </div> 
                                </div>
                                <div class="form-group">
                                    <label for="input_last_name" class="col-md-4 control-label requiredField">
                                        Last Name
                                    </label>
                                    <div class ="col-md-8">
                                        <?php echo form_input(array('name' => 'input_last_name', 'id' => 'input_last_name', 'class' => 'form-control')); ?>
                                    </div> 
                                </div>
                                <div class="form-group">
                                    <label for="input_phone_no" class="col-md-4 control-label requiredField">
                                        Phone No.
                                    </label>
                                    <div class ="col-md-8">
                                        <?php echo form_input(array('name' => 'input_phone_no', 'id' => 'input_phone_no', 'class' => 'form-control')); ?>
                                    </div> 
                                </div>
                                <div class="form-group">
                                    <label for="input_company" class="col-md-4 control-label requiredField">
                                        Company
                                    </label>
                                    <div class ="col-md-8">
                                        <?php echo form_input(array('name' => 'input_company', 'id' => 'input_company', 'class' => 'form-control')); ?>
                                    </div> 
                                </div>
                                <div class="form-group">
                                    <label for="button_add_supplier" class="col-md-4 control-label requiredField">
                                    </label>
                                    <div class ="col-md-8">
                                        <?php echo form_button(array('name' => 'button_add_supplier', 'class' => 'form-control btn btn-success', 'id' => 'button_add_supplier', 'content' => 'Submit')); ?>
                                    </div> 
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button id="button_close_modal_select_supplier" name="button_close_modal_select_supplier" type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

