<script type="text/javascript">
    $(function()
    {
        $("#modal_add_customer #button_add_customer").on("click", function() {
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
                        current_temp_html_customer = current_temp_html_customer + '<div class ="row" id ="span_customer_info"><div class ="col-md-4 col-md-offset-1" id="div_customer_list_id">';
                        current_temp_html_customer = current_temp_html_customer + '<input id="' + customer_info['customer_id'] + '" class="form-control" type="text" value="' + customer_info['phone'] + '"/></div><div class ="col-md-4" id="div_customer_list_id">';
                        current_temp_html_customer = current_temp_html_customer + '<input id="' + customer_info['customer_id'] + '" class="form-control" type="text" value="' + customer_info['card_no'] + '"/></div><div class ="col-md-3">';
                        current_temp_html_customer = current_temp_html_customer + '<a target="_blank" class="view" href="<?php echo base_url(); ?>user/show_customer/' + customer_info['customer_id'] + '">view</a>';
                        current_temp_html_customer = current_temp_html_customer + '</div>';
                        current_temp_html_customer = current_temp_html_customer + '</div>';
                        $("#div_customer_list").html(current_temp_html_customer);
                        update_fields_selected_customer(customer_info);
                        $('#modal_add_customer').modal('hide');
                    }
                }

            });
        });
        $("#div_customer_list #span_customer_info #div_customer_list_id").on("click", "input", function() {
//                console.log("This "+$(this).attr("id")+", parent"+$(this).parent()+", parent parent"+$(this).parent().parent()+","+$(this).parent().parent().attr("id"));
            if ($(this).parent() && $(this).parent().parent() && $(this).parent().parent().attr("id") === "span_customer_info")
            {
                var c_list = get_customer_list();
                for (var counter = 0; counter < c_list.length; counter++)
                {
                    var cust_info = c_list[counter];
                    if ($(this).attr("id") === cust_info['customer_id'])
                    {
                        update_fields_selected_customer(cust_info);
                        $('div[class="clr dropdown open"]').removeClass('open');
                        $('#modal_add_customer').modal('hide');
                        return;
                    }
                }
            }
        });

    });
</script>

<div class ="row modal" id="modal_add_customer" style="margin-left: 2px;">
    <div class ="col-md-3"></div>
    <div class ="col-md-6 modal-style boxshad">
        <div class ="row">
            <div class ="col-md-4 col-md-offset-1">
                <h3>Phone</h3>
            </div>
            <div class ="col-md-4">
                <h3>Card No</h3>
            </div>
            <div class ="col-md-3">
                <h3>Details</h3>
            </div>
        </div>
        <div class ="row" id="div_customer_list">
            <?php foreach ($customer_list_array as $key => $customer) { ?>
                <div class ="row" id ="span_customer_info">
                    <div class ="col-md-4 col-md-offset-1" id="div_customer_list_id">
                        <?php echo form_input(array('name' => 'phone_no', 'value' => $customer['phone'], 'id' => $customer['customer_id'], 'class' => 'form-control')); ?>
                    </div>
                    <div class ="col-md-4"  id="div_customer_list_id">
                        <?php echo form_input(array('name' => $customer['customer_id'], 'value' => $customer['card_no'], 'id' => $customer['customer_id'], 'class' => 'form-control')); ?>            
                    </div>
                    <div class ="col-md-3">
                        <a target="_blank" href="<?php echo base_url() . "user/show_customer/" . $customer['customer_id']; ?>">view</a>
                    </div>
                </div>
            <?php } ?>  
        </div>
        <div class ="row margin-top-bottom">
            <div class ="col-md-4">
                <h3>Search</h3>
            </div>
            <div class ="col-md-4">
                <?php echo form_dropdown('customer_search', $customer_search_category, '0', "id='dropdown_search_customer' class='form-control'"); ?>                
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
                                <label for="input_card_no" class="col-md-4 control-label requiredField">
                                    Card No.
                                </label>
                                <div class ="col-md-6">
                                    <?php echo form_input(array('name' => 'input_card_no', 'id' => 'input_card_no', 'class' => 'form-control')); ?>
                                </div> 
                            </div>

                            <div class="form-group">
                                <label for="button_add_customer" class="col-md-4 control-label requiredField">
                                </label>
                                <div class ="col-md-6">
                                    <?php echo form_button(array('name' => 'button_add_customer', 'id' => 'button_add_customer', 'content' => 'Submit')); ?>
                                </div> 
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>