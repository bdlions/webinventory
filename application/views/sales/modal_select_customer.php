<script type="text/javascript">
    $(function(){
        $("#search_box_customer").typeahead([
            {
                name:"search_customer",
                valuekey:"first_name",
                remote:'<?php echo base_url()?>search/get_active_customers?query=%QUERY',
                header: '<div class="col-md-12" style="font-size: 15px; font-weight:bold">Customer</div>',
                template: [
                    '<div class="row"><div class="tt-suggestions col-md-11"><div class="form-horizontal"><span class="glyphicon glyphicon-user col-md-12">{{first_name}} {{last_name}}</span><span class="glyphicon glyphicon-phone col-md-12">{{phone}}</span><span class="glyphicon glyphicon- col-md-12">{{card_no}}</span></div><div class="tt-suggestions col-md-12" style="border-top: 1px dashed #CCCCCC;margin: 6px 0;"></div></div>'
                  ].join(''),
                engine: Hogan
            }
    ]).on('typeahead:selected', function (obj, datum) {
           if(datum.customer_id)
            {
                $.ajax({
                    dataType: 'json',
                    type: "POST",
                    url: '<?php echo base_url(); ?>' + "customer/get_customer_info",
                    data: {
                        customer_id: datum.customer_id
                    },
                    success: function(data) {
                        if(data.status == 1)
                        {
                            update_fields_selected_customer(data.customer_info);
                            $('#modal_select_customer').modal('hide');
                            return;
                        }
                        else if(data.status == 0)
                        {
                            alert(data.message);
                        }
                        
                    }
                });                
            }
        });
        
        $("#button_add_customer").on("click", function() {
            var first_name = $("#input_first_name").val();
            var last_name = $("#input_last_name").val();
            var phone = $("#input_phone_no").val();
            var country_code = $("#phone_country_code").val();
            var card_no = 0;
            if (first_name.length == 0)
            {
                alert("First Name is required.");
                return;
            }
            else if (last_name.length == 0)
            {
                alert("Last Name is required.");
                return;
            }
            else if (phone.length == 0)
            {
                alert("Phone is required.");
                return;
            }
            else if (country_code.length == 0)
            {
                alert("phone Country Code is required.");
                return;
            }
            
            <?php if($shop_info['shop_type_id'] == SHOP_TYPE_SMALL){?>
            else if ($("#input_card_no").val().length == 0)
            {
                alert("Card No is required.");
                return;
            }
            <?php }else{?>
                card_no = $("#input_card_no").val();
            <?php }?>
            $.ajax({
                dataType: 'json',    
                type: "POST",
                url: '<?php echo base_url(); ?>' + "customer/create_customer_sale_order",
                data: {
                    first_name: first_name,
                    last_name: last_name,
                    phone_no: phone,
                    card_no: card_no,
                    country_code: country_code
                },
                success: function(data) {
                    
                    if (data['status'] === '1')
                    {
                        alert('New customer is added successfully.');
                        var customer_info = data['customer_info'];
                        update_fields_selected_customer(customer_info);
                        $('#modal_select_customer').modal('hide');
                    }
                    else{
                        alert(data['message']);
                    }
                }
            });
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
                                    <input type="text" placeholder="Search for customer" class="form-control tt-query" id="search_box_customer" autocomplete="off" spellcheck="false" style="position: relative; vertical-align: top; background-color: transparent;" dir="auto">
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
                    <div class ="row col-md-11">
                        <div class ="col-md-3">
                            <h3>Add New</h3>
                        </div>
                        <div class ="col-md-9">
                            <div class="form-horizontal">
                                <div class="row form-group">
                                    <label for="input_first_name" class="col-md-5 control-label requiredField">
                                        First Name
                                    </label>
                                    <div class ="col-md-7">
                                        <?php echo form_input(array('name' => 'input_first_name', 'id' => 'input_first_name', 'class' => 'form-control')); ?>
                                    </div> 
                                </div>
                                <div class="form-group">
                                    <label for="input_last_name" class="col-md-5 control-label requiredField">
                                        Last Name
                                    </label>
                                    <div class ="col-md-7">
                                        <?php echo form_input(array('name' => 'input_last_name', 'id' => 'input_last_name', 'class' => 'form-control')); ?>
                                    </div> 
                                </div>
                                
                                
                                <div class="form-group">
                                    <label for="country_code" class="col-md-5 control-label requiredField">
                                        Phone Country Code
                                    </label>
                                    <div class ="col-md-7">
                                        <?php echo form_input(array('name' => 'phone_country_code', 'id' => 'phone_country_code', 'class' => 'form-control')); ?>
                                    </div> 
                                </div> 
                                <div class="form-group">
                                    <label for="input_phone_no" class="col-md-5 control-label requiredField">
                                        Phone No.
                                    </label>
                                    <div class ="col-md-7">
                                        <?php echo form_input(array('name' => 'input_phone_no', 'id' => 'input_phone_no', 'class' => 'form-control')); ?>
                                    </div> 
                                </div>   
                                <?php if($shop_info['shop_type_id'] == SHOP_TYPE_SMALL){?>
                                <div class="form-group">
                                    <label for="input_card_no" class="col-md-5 control-label requiredField">
                                        Card No
                                    </label>
                                    <div class ="col-md-7">
                                        <?php echo form_input(array('name' => 'input_card_no', 'id' => 'input_card_no', 'class' => 'form-control')); ?>
                                    </div> 
                                </div>
                                <?php }?>
                                <div class="form-group">
                                    <label for="button_add_customer" class="col-md-5 control-label requiredField">
                                    </label>
                                    <div class ="col-md-7">
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
