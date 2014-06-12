
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
                    company: $("#input_company").val(),
                    message_category_id: $("#message_category_list").val()
                },
                success: function(data) {
                    if (data['status'] === '1')
                    {
                        var s_list = get_supplier_list();
                        s_list[s_list.length] = data['supplier_info'];
                        set_supplier_list(s_list);
                        alert(data.message);
                        var supplier_info = data['supplier_info'];
                        //$("#tbody_supplier_list").html($("#tbody_supplier_list").html()+tmpl("tmpl_supplier_list", supplier_info));
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

<script type="text/javascript">
    $(function(){
        $("#search_box").typeahead([
            {
                name:"search_supplier",
                valuekey:"first_name",
                local:<?php echo $searched_suppliers;?>,
                /*prefetch:{
                            url: '<?php echo base_url()?>search/get_supplier',
                            ttl: 0
                        },*/
                header: '<div class="col-md-12" style="font-size: 15px; font-weight:bold">Supplier</div>',
                template: [
                    '<div class="row"><div class="tt-suggestions col-md-11"><div class="form-horizontal"><span class="glyphicon glyphicon-user col-md-12">{{first_name}} {{last_name}}</span><span class="glyphicon glyphicon-phone col-md-12">{{phone}}</span><span class="glyphicon glyphicon- col-md-12">{{company}}</span></div><div class="tt-suggestions col-md-12" style="border-top: 1px dashed #CCCCCC;margin: 6px 0;"></div></div>'
                  ].join(''),
                engine: Hogan
            }
    ]).on('typeahead:selected', function (obj, datum) {
           if(datum.first_name)
            {
                var s_list = get_supplier_list();
                for (var counter = 0; counter < s_list.length; counter++)
                {
                    var sup_info = s_list[counter];
                    if (datum.supplier_id === sup_info['supplier_id'])
                    {
                        update_fields_selected_supplier(sup_info);
                        $('#modal_select_supplier').modal('hide');
                        return;
                    }
                }
            }
        });  
    });
</script>
<!--
<div class="row">
    <div class="col-md-11">
        <div class="form-horizontal">
            <span class="glyphicon glyphicon-user col-md-12">
                Omar Faruk
            </span>
            <span class="glyphicon glyphicon-phone col-md-12">
                01725724068
            </span>
            <span class="glyphicon glyphicon- col-md-12">
                Sampan
            </span>
        </div>
    </div>
    <div class="col-md-2" style="border-top: 1px dashed #CCCCCC;margin: 6px 0;padding: 0px 0;">
    </div>
</div>
-->

<div class="modal fade" id="modal_select_supplier" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Select Supplier</h4>
            </div>
            <div class="modal-body">
                <div class ="row col-md-offset-1">
                    <div class="col-md-offset-2 col-md-6">
                            <div class=" input-group search-box">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span>
                                <div class="twitter-typeahead" style="position: relative;">
                                    <input type="text" disabled="" spellcheck="off" autocomplete="off" class="tt-hint form-control" style="position: absolute; top: 0px; left: 0px; border-color: transparent; box-shadow: none; background: none repeat scroll 0% 0% rgb(255, 255, 255);">
                                    <input type="text" placeholder="Search for supplier" class="form-control tt-query" id="search_box" autocomplete="off" spellcheck="false" style="position: relative; vertical-align: top; background-color: transparent;" dir="auto">
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
                    
                    <!-- <div class="row col-md-11">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Phone</th>
                                        <th>Company</th>
                                        <th>Update</th>
                                        <th>Show</th>
                                        <th>Transactions</th>
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
                                            <td><a target="_blank" href="<?php echo base_url() . "user/update_supplier/" . $supplier['supplier_id']; ?>">Update</a></td>
                                            <td><a target="_blank" href="<?php echo base_url() . "user/show_supplier/" . $supplier['supplier_id']; ?>">Show</a></td>
                                            <td><a target="_blank" href="<?php echo base_url() . "payment/show_supplier_transactions/" . $supplier['supplier_id']; ?>">Show</a></td>
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
                                        <td><a target="_blank" href="<?php echo base_url() . "user/update_supplier/" . '{%= supplier_info.supplier_id%}'; ?>">Update</a></td>
                                        <td><a target="_blank" href="<?php echo base_url() . "user/show_supplier/" . '{%= supplier_info.supplier_id%}'; ?>">Show</a></td>
                                        <td><a target="_blank" href="<?php echo base_url() . "payment/show_supplier_transactions/" . '{%= supplier_info.supplier_id%}'; ?>">Show</a></td>            
                                    </tr>
                                    {% supplier_info = ((o instanceof Array) ? o[i++] : null); %}
                                    {% } %}
                                </script>
                                </tbody>
                            </table>
                        </div>
                    </div> -->                                        
                    <!-- <div class ="row col-md-11 top-bottom-padding">
                        <div class ="col-md-4">
                            <h3>Search</h3>
                        </div>
                        <div class ="col-md-4">
                            <?php //echo form_dropdown('dropdown_search_supplier', $supplier_search_category, '0', 'id="dropdown_search_supplier"'); ?>
                        </div>
                        <div class ="col-md-4">
                            <div class="row form-group">
                                <div class="col-md-12">
                                    <?php //echo form_input(array('name' => 'input_search_supplier', 'id' => 'input_search_supplier', 'class' => 'form-control')); ?>
                                </div>
                            </div>                            
                            <div class ="row form-group">
                                <div class="col-md-12">
                                    <?php //echo form_button(array('name' => 'button_search_supplier', 'class' => 'form-control btn btn-success', 'id' => 'button_search_supplier', 'content' => 'Search')); ?>
                                </div>
                            </div>
                        </div>                      
                    </div> -->

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
<!--                                <div class="form-group">
                                    <label for="address" class="col-md-4 control-label requiredField">
                                        Message Category
                                    </label>
                                    <div class ="col-md-8">
                                        <?php echo form_dropdown('message_category_list', $message_category_list+array('' => 'Select'), '', 'class=form-control id="message_category_list"'); ?>
                                    </div> 
                                </div>-->
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

