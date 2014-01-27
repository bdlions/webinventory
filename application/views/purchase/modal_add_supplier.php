<script type="text/javascript">
    $(function()
    {
        $("#modal_add_supplier #button_add_supplier").on("click", function() {
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
                alert("Card No is required.");
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
                        current_temp_html_supplier = current_temp_html_supplier + '<div class ="row" id ="span_customer_info"><div class ="col-md-4 col-md-offset-1" id="div_customer_list_id">';
                        current_temp_html_supplier = current_temp_html_supplier + '<input id="' + supplier_info['supplier_id'] + '" class="fl" type="text" value="' + supplier_info['phone'] + '"/>';
                        current_temp_html_supplier = current_temp_html_supplier + '<input id="' + supplier_info['supplier_id'] + '" class="fl" type="text" value="' + supplier_info['company'] + '"/>';
                        current_temp_html_supplier = current_temp_html_supplier + '<span class="span10 view sales_view fl" style="">';
                        current_temp_html_supplier = current_temp_html_supplier + '<a target="_blank" class="view" href="<?php echo base_url(); ?>user/show_supplier/' + supplier_info['supplier_id'] + '">view</a>';
                        current_temp_html_supplier = current_temp_html_supplier + '</span>';
                        current_temp_html_supplier = current_temp_html_supplier + '</span>';
                        $("#div_supplier_list").html(current_temp_html_supplier);
                        update_fields_selected_supplier(supplier_info);
                        $('#modal_add_supplier').modal('hide');
                    }
                }

            });
        });
        $("#div_supplier_list #span_customer_info #div_supplier_list_id").on("click", "input", function() {
//                console.log("This "+$(this).attr("id")+", parent"+$(this).parent()+", parent parent"+$(this).parent().parent()+","+$(this).parent().parent().attr("id"));
            if ($(this).parent() && $(this).parent().parent() && $(this).parent().parent().attr("id") === "span_customer_info")
            {
                var c_list = get_supplier_list();
                console.log(c_list);
                for (var counter = 0; counter < c_list.length; counter++)
                {
                    var cust_info = c_list[counter];
                    if ($(this).attr("id") === cust_info['supplier_id'])
                    {
                        update_fields_selected_supplier(cust_info);
                        $('div[class="clr dropdown open"]').removeClass('open');
                        $('#modal_add_supplier').modal('hide');
                        return;
                    }
                }
            }
        });

    });
</script>

<div class ="row modal" id="modal_add_supplier">
    <div class ="col-md-3"></div>
    <div class ="col-md-6 modal-style form-background">
        <div class ="row">
            <div class ="col-md-4 col-md-offset-1">
                <h3>Phone</h3>
            </div>
            <div class ="col-md-4">
                <h3>Company</h3>
            </div>
            <div class ="col-md-3">
                <h3>Details</h3>
            </div>
        </div>
        <div class ="row" id="div_supplier_list">
            <?php
            foreach ($supplier_list_array as $key => $supplier) {
                ?>
                <div class ="row" id ="span_customer_info">
                    <div class ="col-md-4 col-md-offset-1" id="div_supplier_list_id">
                        <?php echo form_input(array('name' => $supplier['supplier_id'], 'value' => $supplier['phone'], 'id' => $supplier['supplier_id'], 'class' => 'form-control')); ?>
                    </div>
                    <div class ="col-md-4"  id="div_supplier_list_id">
                        <?php echo form_input(array('name' => $supplier['supplier_id'], 'value' => $supplier['company'], 'id' => $supplier['supplier_id'], 'class' => 'form-control')); ?>            
                    </div>
                    <div class ="col-md-3">
                        <a target="_blank" href="<?php echo base_url() . "user/show_supplier/" . $supplier['supplier_id']; ?>">view</a>
                    </div>
                </div>
            <?php } ?>  
        </div>
        <div class ="row margin-top-bottom">
            <div class ="col-md-4">
                <h3>Search</h3>
            </div>
            <div class ="col-md-4">
                <?php echo form_dropdown('dropdown_search_supplier', $supplier_search_category, '0', 'id="dropdown_search_supplier"'); ?>
            </div>
            <div class ="col-md-4">
                <?php echo form_input(array('name' => 'input_search_supplier', 'id' => 'input_search_supplier', 'class' => 'form-control')); ?>
                <div class ="row">
                    <div class ="col-md-4">
                        <?php echo form_button(array('name' => 'button_search_supplier', 'id' => 'button_search_supplier', 'content' => 'Search')); ?>
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
                                <label for="input_first_name" class="col-md-4 control-label requiredField">
                                    First Name
                                </label>
                                <div class ="col-md-6">
                                    <?php echo form_input(array('name' => 'input_first_name', 'id' => 'input_first_name', 'class' => 'form-control')); ?>
                                </div> 
                            </div>

                            <div class="form-group">
                                <label for="input_last_name" class="col-md-4 control-label requiredField">
                                    Last Name
                                </label>
                                <div class ="col-md-6">
                                    <?php echo form_input(array('name' => 'input_last_name', 'id' => 'input_last_name', 'class' => 'form-control')); ?>
                                </div> 
                            </div>


                            <div class="form-group">
                                <label for="input_phone_no" class="col-md-4 control-label requiredField">
                                    Phone No.
                                </label>
                                <div class ="col-md-6">
                                    <?php echo form_input(array('name' => 'input_phone_no', 'id' => 'input_phone_no', 'class' => 'form-control')); ?>
                                </div> 
                            </div>

                            <div class="form-group">
                                <label for="input_company" class="col-md-4 control-label requiredField">
                                    Company
                                </label>
                                <div class ="col-md-6">
                                    <?php echo form_input(array('name' => 'input_company', 'id' => 'input_company', 'class' => 'form-control')); ?>
                                </div> 
                            </div>

                            <div class="form-group">
                                <label for="button_add_supplier" class="col-md-4 control-label requiredField">
                                </label>
                                <div class ="col-md-6">
                                    <?php echo form_button(array('name' => 'button_add_supplier', 'id' => 'button_add_supplier', 'content' => 'Submit')); ?>
                                </div> 
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>