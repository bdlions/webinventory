<script type="text/javascript">
    $(function()
    {
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
                dataType: 'json',    
                type: "POST",
                url: '<?php echo base_url(); ?>' + "user/create_customer_sale_order",
                data: {
                    first_name: $("#input_first_name").val(),
                    last_name: $("#input_last_name").val(),
                    phone_no: $("#input_phone_no").val(),
                    card_no: $("#input_card_no").val()
                },
                success: function(data) {
                    if (data['status'] === '1')
                    {
                        var c_list = get_customer_list();
                        c_list[c_list.length] = data['customer_info'];
                        set_customer_list(c_list);
                        alert('New customer is added successfully.');
                        var customer_info = data['customer_info'];
                        $("#tbody_customer_list").html($("#tbody_customer_list").html()+tmpl("tmpl_customer_list", customer_info));
                        update_fields_selected_customer(customer_info);
                        $('#modal_select_customer').modal('hide');
                    }
                }
            });
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
                dataType: 'json',
                type: "POST",
                url: '<?php echo base_url(); ?>' + "search/search_customer_sale_order",
                data: {
                    search_category_name: $("#dropdown_search_customer").val(),
                    search_category_value: $("#input_search_customer").val()
                },
                success: function(data) {
                    $("#tbody_customer_list").html(tmpl("tmpl_customer_list", data));
                    set_customer_list(data);                    
                }
            });
        });
        $("#tbody_customer_list").on("click", "td", function() {
            var c_list = get_customer_list();
            for (var counter = 0; counter < c_list.length; counter++)
            {
                var cust_info = c_list[counter];
                if ($(this).attr("id") === cust_info['customer_id'])
                {
                    update_fields_selected_customer(cust_info);
                    $('div[class="clr dropdown open"]').removeClass('open');
                    $('#modal_select_customer').modal('hide');
                    return;
                }
            }            
        });
    });
</script>

<div class="modal fade" id="modal_select_customer" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Select Customer</h4>
            </div>
            <div class="modal-body">
                <div class="row col-md-offset-1">
                    <div class="row col-md-11">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Phone</th>
                                        <th>Card No</th>
                                        <th>Details</th>
                                    </tr>
                                </thead>
                                <tbody id="tbody_customer_list">
                                    <?php
                                    foreach ($customer_list_array as $key => $customer) {
                                        ?>
                                        <tr>
                                            <td id="<?php echo $customer['customer_id'] ?>"><?php echo $customer['first_name'] . ' ' . $customer['last_name'] ?></td>
                                            <td id="<?php echo $customer['customer_id'] ?>"><?php echo $customer['phone'] ?></td>
                                            <td id="<?php echo $customer['customer_id'] ?>"><?php echo $customer['card_no'] ?></td>
                                            <td><a target="_blank" href="<?php echo base_url() . "user/show_customer/" . $customer['customer_id']; ?>">view</a></td>
                                        </tr>
                                        <?php
                                    }
                                    ?>
                                <script type="text/x-tmpl" id="tmpl_customer_list">
                                    {% var i=0, customer_info = ((o instanceof Array) ? o[i++] : o); %}
                                    {% while(customer_info){ %}
                                    <tr>
                                    <td id="<?php echo '{%= customer_info.customer_id%}'; ?>"><?php echo '{%= customer_info.first_name%}' . ' ' . '{%= customer_info.last_name%}'; ?></td>
                                    <td id="<?php echo '{%= customer_info.customer_id%}'; ?>"><?php echo '{%= customer_info.phone%}'; ?></td>
                                    <td id="<?php echo '{%= customer_info.customer_id%}'; ?>"><?php echo '{%= customer_info.card_no%}'; ?></td>
                                    <td><a target="_blank" href="<?php echo base_url() . "user/show_customer/" . '{%= customer_info.customer_id%}'; ?>">view</a></td>
                                    </tr>
                                    {% customer_info = ((o instanceof Array) ? o[i++] : null); %}
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
                            <?php echo form_dropdown('dropdown_search_customer', $customer_search_category, '0', 'id="dropdown_search_customer"'); ?>
                        </div>
                        <div class ="col-md-4">
                            <div class="row form-group">
                                <div class="col-md-12">
                                    <?php echo form_input(array('name' => 'input_search_customer', 'id' => 'input_search_customer', 'class' => 'form-control')); ?>
                                </div>
                            </div>                            
                            <div class ="row form-group">
                                <div class="col-md-12">
                                    <?php echo form_button(array('name' => 'button_search_customer', 'class' => 'form-control btn btn-success', 'id' => 'button_search_customer', 'content' => 'Search')); ?>
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
                                    <label for="input_card_no" class="col-md-4 control-label requiredField">
                                        Card No
                                    </label>
                                    <div class ="col-md-8">
                                        <?php echo form_input(array('name' => 'input_card_no', 'id' => 'input_card_no', 'class' => 'form-control')); ?>
                                    </div> 
                                </div>
                                <div class="form-group">
                                    <label for="button_add_customer" class="col-md-4 control-label requiredField">
                                    </label>
                                    <div class ="col-md-8">
                                        <?php echo form_button(array('name' => 'button_add_customer', 'class' => 'form-control btn btn-success', 'id' => 'button_add_customer', 'content' => 'Submit')); ?>
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