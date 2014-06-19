<script type="text/javascript">
    $(function()
    {
        $("#button_add_supplier").on("click", function() 
        {
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
                        alert(data.message);
                        var supplier_info = data['supplier_info'];
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
        $("#button_close_modal_select_supplier").on("click", function() {
            $('#modal_select_supplier').modal('hide');
        });
    });
</script>

<script type="text/javascript">
    $(function(){
        $("#search_box_supplier").typeahead([
            {
                name:"search_supplier",
                valuekey:"first_name",
                remote:'<?php echo base_url()?>search/get_suppliers?query=%QUERY',
                header: '<div class="col-md-12" style="font-size: 15px; font-weight:bold">Supplier</div>',
                template: [
                    '<div class="row"><div class="tt-suggestions col-md-11"><div class="form-horizontal"><span class="glyphicon glyphicon-user col-md-12">{{first_name}} {{last_name}}</span><span class="glyphicon glyphicon-phone col-md-12">{{phone}}</span><span class="glyphicon glyphicon- col-md-12">{{company}}</span></div><div class="tt-suggestions col-md-12" style="border-top: 1px dashed #CCCCCC;margin: 6px 0;"></div></div>'
                  ].join(''),
                engine: Hogan
            }
    ]).on('typeahead:selected', function (obj, datum) {
           if(datum.supplier_id)
            {
                $.ajax({
                    dataType: 'json',
                    type: "POST",
                    url: '<?php echo base_url(); ?>' + "search/get_supplier_info",
                    data: {
                        supplier_id: datum.supplier_id
                    },
                    success: function(data) {
                        if(data.status == 1)
                        {
                            update_fields_selected_supplier(data.supplier_info);
                            $('#modal_select_supplier').modal('hide');
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
                    <div class="col-md-offset-2 col-md-6">
                            <div class=" input-group search-box">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span>
                                <div class="twitter-typeahead" style="position: relative;">
                                    <input type="text" disabled="" spellcheck="off" autocomplete="off" class="tt-hint form-control" style="position: absolute; top: 0px; left: 0px; border-color: transparent; box-shadow: none; background: none repeat scroll 0% 0% rgb(255, 255, 255);">
                                    <input type="text" placeholder="Search for supplier" class="form-control tt-query" id="search_box_supplier" autocomplete="off" spellcheck="false" style="position: relative; vertical-align: top; background-color: transparent;" dir="auto">
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