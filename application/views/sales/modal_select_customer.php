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
                    card_no: $("#input_card_no").val(),
                    message_category_id: $("#message_category_list").val()
                },
                success: function(data) {
                    if (data['status'] === '1')
                    {
                        var c_list = get_customer_list();
                        c_list[c_list.length] = data['customer_info'];
                        set_customer_list(c_list);
                        alert('New customer is added successfully.');
                        var customer_info = data['customer_info'];
                        //$("#tbody_customer_list").html($("#tbody_customer_list").html()+tmpl("tmpl_customer_list", customer_info));
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

<script type="text/javascript">
    $(function(){
        $("#search_box").typeahead([
            {
                name:"search_customer",
                valuekey:"first_name",
                prefetch:{
                            url: '<?php echo base_url()?>search/get_customer',
                            ttl: 0
                        },
                header: '<div class="col-md-12" style="font-size: 15px; font-weight:bold">Customer</div>',
                template: [
                    '<div class="row"><div class="tt-suggestions col-md-11"><div class="form-horizontal"><span class="glyphicon glyphicon-user col-md-12">{{first_name}} {{last_name}}</span><span class="glyphicon glyphicon-phone col-md-12">{{phone}}</span><span class="glyphicon glyphicon- col-md-12">{{card_no}}</span></div><div class="tt-suggestions col-md-12" style="border-top: 1px dashed #CCCCCC;margin: 6px 0;"></div></div>'
                  ].join(''),
                engine: Hogan
            }
    ]).on('typeahead:selected', function (obj, datum) {
           if(datum.first_name)
            {
                var c_list = get_customer_list();
                for (var counter = 0; counter < c_list.length; counter++)
                {
                    var cust_info = c_list[counter];
                    if (datum.customer_id === cust_info['customer_id'])
                    {
                        update_fields_selected_customer(cust_info);
                        $('#modal_select_customer').modal('hide');
                        return;
                    }
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
                    
                    <div class="col-md-offset-2 col-md-6">
                            <div class=" input-group search-box">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span>
                                <div class="twitter-typeahead" style="position: relative;">
                                    <input type="text" disabled="" spellcheck="off" autocomplete="off" class="tt-hint form-control" style="position: absolute; top: 0px; left: 0px; border-color: transparent; box-shadow: none; background: none repeat scroll 0% 0% rgb(255, 255, 255);">
                                    <input type="text" placeholder="Search for customer" class="form-control tt-query" id="search_box" autocomplete="off" spellcheck="false" style="position: relative; vertical-align: top; background-color: transparent;" dir="auto">
                                    <div style="position: absolute; left: -9999px; visibility: hidden; white-space: nowrap; font-family: Calibri,Arial,Helvetica,sans-serif; font-size: 12px; font-style: normal; font-variant: normal; font-weight: 400; word-spacing: 0px; letter-spacing: 0px; text-indent: 0px; text-rendering: optimizelegibility; text-transform: none;">
                                        
                                    </div>
                                    <div class="tt-dropdown-menu dropdown-menu" style="position: absolute; top: 100%; left: 0px; z-index: 100; display: none;">
                                        
                                    </div>    
                                </div>
                            </div>
                        </div>
                        <br>
                        <br>
                        <br>
                        <br>
                        <br>
                        <br>
                    
                    <!--<div class="row col-md-11">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Phone</th>
                                        <th>Card No</th>
                                        <th>Update</th>
                                        <th>Show</th>
                                        <th>Transactions</th>
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
                                            <td><a target="_blank" href="<?php echo base_url() . "user/update_customer/" . $customer['customer_id']; ?>">Update</a></td>
                                            <td><a target="_blank" href="<?php echo base_url() . "user/show_customer/" . $customer['customer_id']; ?>">Show</a></td>
                                            <td><a target="_blank" href="<?php echo base_url() . "payment/show_customer_transactions/" . $customer['customer_id']; ?>">Show</a></td>
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
                                        <td><a target="_blank" href="<?php echo base_url() . "user/update_customer/" . '{%= customer_info.customer_id%}'; ?>">Update</a></td>
                                        <td><a target="_blank" href="<?php echo base_url() . "user/show_customer/" . '{%= customer_info.customer_id%}'; ?>">Show</a></td>
                                        <td><a target="_blank" href="<?php echo base_url() . "payment/show_customer_transactions/" . '{%= customer_info.customer_id%}'; ?>">Show</a></td>            
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
                    </div>-->
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
                                
                                <?php if($shop_info['shop_type_id'] == SHOP_TYPE_SMALL){?>
                                <div class="form-group">
                                    <label for="input_card_no" class="col-md-4 control-label requiredField">
                                        Card No
                                    </label>
                                    <div class ="col-md-8">
                                        <?php echo form_input(array('name' => 'input_card_no', 'id' => 'input_card_no', 'class' => 'form-control')); ?>
                                    </div> 
                                </div>
                                <?php }?>
                                
                                <div class="form-group">
                                    <label for="address" class="col-md-4 control-label requiredField">
                                        Message Category
                                    </label>
                                    <div class ="col-md-8">
                                        <?php echo form_dropdown('message_category_list', $message_category_list+array('' => 'Select'), '', 'class=form-control id="message_category_list"'); ?>
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
