<script type="text/javascript">
    $(function()
    {
        $("#button_add_due_collect").on("click", function() {
            var due_amount = 0;
            var customer_id = 0;
            $("input", "#tbody_due_collect_customer_list").each(function() {
                if ($(this).attr("name") === "input_due_amount")
                {
                    due_amount = $(this).val();
                }
            });
            $("td", "#tbody_due_collect_customer_list").each(function() {
                if ($(this).attr("id"))
                {
                    customer_id = $(this).attr("id");
                    return;
                }
            });
            if(customer_id < 0)
            {
                alert("Please search a customer.");
                return;
            }
            if(due_amount <= 0)
            {
                alert("Please assign due amount.");
                return;
            }
            
            $.ajax({
                dataType: 'json',    
                type: "POST",
                url: '<?php echo base_url(); ?>' + "payment/add_due_collect",
                data: {
                    customer_id: customer_id,
                    amount: due_amount
                },
                success: function(data) {
                    if(data == 1)
                    {
                        alert('Due collect amount successfully stored.');
                        var c_list = get_customer_list();
                        for (var counter = 0; counter < c_list.length; counter++)
                        {
                            var cust_info = c_list[counter];
                            if (cust_info['customer_id'] === customer_id)
                            {
                                update_fields_selected_customer(cust_info);
                                $('#modal_due_collect').modal('hide');
                                return;
                            }
                        }   
                    }
                    else
                    {
                        alert('Error while storing due collect amount.');
                    }
                }
            });
        });
        $("#button_due_collect_search_customer").on("click", function() {
            if ($("#dropdown_due_collect_search_customer")[0].selectedIndex == 0)
            {
                alert("Please select search criteria.");
                return false;
            }
            else if ($("#input_due_collect_search_customer").val().length == 0)
            {
                alert("Please assign value of search criteria");
                return false;
            }
            $.ajax({
                dataType: 'json',
                type: "POST",
                url: '<?php echo base_url(); ?>' + "search/search_customer_sale_order",
                data: {
                    search_category_name: $("#dropdown_due_collect_search_customer").val(),
                    search_category_value: $("#input_due_collect_search_customer").val()
                },
                success: function(data) {
                    $("#tbody_due_collect_customer_list").html(tmpl("tmpl_due_collect_customer_list", data));
                    set_customer_list(data);                    
                }
            });
        });        
    });
</script>

<div class="modal fade" id="modal_due_collect" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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
                                        <th>Current Due Amount</th>
                                        <th>Due Amount</th>
                                    </tr>
                                </thead>
                                <tbody id="tbody_due_collect_customer_list">                                    
                                <script type="text/x-tmpl" id="tmpl_due_collect_customer_list">
                                    {% var i=0, customer_info = ((o instanceof Array) ? o[i++] : o); %}
                                    {% while(customer_info){ %}
                                    <tr>
                                    <td id="<?php echo '{%= customer_info.customer_id%}'; ?>"><?php echo '{%= customer_info.first_name%}' . ' ' . '{%= customer_info.last_name%}'; ?></td>
                                    <td id="<?php echo '{%= customer_info.customer_id%}'; ?>"><?php echo '{%= customer_info.phone%}'; ?></td>
                                    <td id="<?php echo '{%= customer_info.customer_id%}'; ?>"><?php echo '{%= customer_info.card_no%}'; ?></td>
                                    <td id="<?php echo '{%= customer_info.customer_id%}'; ?>"><?php echo '{%= customer_info.due_amount%}'; ?></td>
                                    <td><input class="input-width-table" id="input_due_amount" name="input_due_amount" type="text" value="0"/></td>
                                    </tr>
                                    {% customer_info = ((o instanceof Array) ? o[i++] : null); %}
                                    {% break; %}
                                    {% } %}
                                
                                </script>
                                </tbody>
                            </table>
                        </div>
                        <div class="form-group">
                            <label for="button_add_due_collect" class="col-md-8 control-label requiredField">
                            </label>
                            <div class ="col-md-4">
                                <?php echo form_button(array('name' => 'button_add_due_collect', 'class' => 'form-control btn btn-success', 'id' => 'button_add_due_collect', 'content' => 'Save')); ?>
                            </div> 
                        </div>
                    </div> 
                    <div class ="row col-md-11 top-bottom-padding">
                        <div class ="col-md-4">
                            <h3>Search</h3>
                        </div>
                        <div class ="col-md-4">
                            <?php echo form_dropdown('dropdown_due_collect_search_customer', $customer_search_category, '0', 'id="dropdown_due_collect_search_customer"'); ?>
                        </div>
                        <div class ="col-md-4">
                            <div class="row form-group">
                                <div class="col-md-12">
                                    <?php echo form_input(array('name' => 'input_due_collect_search_customer', 'id' => 'input_due_collect_search_customer', 'class' => 'form-control')); ?>
                                </div>
                            </div>                            
                            <div class ="row form-group">
                                <div class="col-md-12">
                                    <?php echo form_button(array('name' => 'button_due_collect_search_customer', 'class' => 'form-control btn btn-success', 'id' => 'button_due_collect_search_customer', 'content' => 'Search')); ?>
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
