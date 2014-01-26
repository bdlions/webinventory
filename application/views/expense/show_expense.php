<script type="text/javascript">
    $(function() {
        $("#div_expense_description").html("");
        $("#div_expense_amount").html("");

        $('#show_expense_start_date').datepicker({
            format: 'yyyy-mm-dd',
            startDate: '-3d'
        }).on('changeDate', function(ev) {
            $('#show_expense_start_date').text($('#show_expense_start_date').data('date'));
            $('#show_expense_start_date').datepicker('hide');
        });
        $('#show_expense_end_date').datepicker({
            format: 'yyyy-mm-dd',
            startDate: '-3d'
        }).on('changeDate', function(ev) {
            $('#show_expense_end_date').text($('#show_expense_end_date').data('date'));
            $('#show_expense_end_date').datepicker('hide');
        });
        $("#expense_categories").on("change", function() {
            $.ajax({
                type: "POST",
                url: '<?php echo base_url(); ?>' + "expense/getItems",
                data: {
                    expense_type_id: $("#expense_categories").val()
                },
                success: function(data) {
                    var result = JSON.parse(data);
                    if ($("#expense_categories").val() === '<?php echo $expense_type_list['shop'] ?>')
                    {
                        $("#item_list").html("");
                        var shop_list = result['shop_list'];
                        var options = "";
                        for (var counter = 0; counter < shop_list.length; counter++)
                        {
                            options += "<option value=\"" + shop_list[counter]['id'] + "\">" + shop_list[counter]['value'] + "</option>";
                        }
                        $("#item_list").html(options);
                    }
                    else if ($("#expense_categories").val() === '<?php echo $expense_type_list['supplier'] ?>')
                    {
                        $("#item_list").html("");
                        var supplier_list = result['supplier_list'];
                        var options = "";
                        for (var counter = 0; counter < supplier_list.length; counter++)
                        {
                            options += "<option value=\"" + supplier_list[counter]['id'] + "\">" + supplier_list[counter]['value'] + "</option>";
                        }
                        $("#item_list").html(options);
                    }
                    else if ($("#expense_categories").val() === '<?php echo $expense_type_list['user'] ?>')
                    {
                        $("#item_list").html("");
                        var user_list = result['user_list'];
                        var options = "";
                        for (var counter = 0; counter < user_list.length; counter++)
                        {
                            options += "<option value=\"" + user_list[counter]['id'] + "\">" + user_list[counter]['value'] + "</option>";
                        }
                        $("#item_list").html(options);
                    }
                    else
                    {
                        $("#item_list").html("");
                    }
                    $("#div_expense_description").html("");
                    $("#div_expense_amount").html("");
                }
            });
        });

        $("#button_search_expense").on("click", function() {
            $.ajax({
                type: "POST",
                url: '<?php echo base_url(); ?>' + "expense/get_expense",
                data: {
                    expense_type_id: $("#expense_categories").val(),
                    start_date: $("#show_expense_start_date").val(),
                    end_date: $("#show_expense_end_date").val()
                },
                success: function(data) {
                    var result = JSON.parse(data);
                    var expense_list = result['expense_list'];
                    var div_expense_description = '';
                    for (var counter = 0; counter < expense_list.length; counter++)
                    {
                        var expense_info = expense_list[counter];
                        div_expense_description += '<div class="row">';
                        div_expense_description += '<div class ="col-md-3">'+''+'</div>';
                        div_expense_description += '<div class ="col-md-3">'+expense_info['expense_amount']+'</div>';
                        div_expense_description += '<div class ="col-md-3">'+expense_info['description']+'</div>';
                        div_expense_description += '<div class ="col-md-3">'+''+'</div>';
                        div_expense_description += '</div>';
                    }
                    
                    $("#div_expense_search_result").html(div_expense_description);
                }
            });
        });
    });
</script>
<div class ="row form-background">
    <div class ="col-md-6">
        <div class ="row">
            <div class ="col-md-12 form-horizontal">
                <div class="row">
                    <div class ="col-md-6 margin-top-bottom">
                        <div class="form-group">
                            <label for="expense_categories" class="col-md-6 control-label requiredField">
                                Select Type
                            </label>
                            <div class ="col-md-6">
                                <?php echo form_dropdown('expense_categories', $expense_categories+ array('0' => 'All'), '','class="form-control" id="expense_categories"'); ?>
                            </div> 
                        </div>
                        <div class="form-group">
                            <label for="item_list" class="col-md-6 control-label requiredField">
                                Select Item
                            </label>
                            <div class ="col-md-6">
                                <?php echo form_dropdown('item_list', $item_list, '', 'class="form-control" id="item_list"'); ?>
                            </div> 
                        </div>
                        <div class="form-group">
                            <label for="address" class="col-md-6 control-label requiredField">

                            </label>
                            <div class ="col-md-6">
                                <?php echo form_input($button_search_expense+array('class'=>'form-control btn-success')); ?>
                            </div> 
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>  
    <div class ="col-md-6">
        <div class ="row">
            <div class ="col-md-12 form-horizontal">
                <div class="row">
                    <div class ="col-md-6 margin-top-bottom">
                        <div class="form-group">
                            <label for="expense_categories" class="col-md-6 control-label requiredField">
                                Start Date
                            </label>
                            <div class ="col-md-6">
                               <?php echo form_input($show_expense_start_date+array('class'=>'form-control')); ?>
                            </div> 
                        </div>
                        <div class="form-group">
                            <label for="item_list" class="col-md-6 control-label requiredField">
                                End Date
                            </label>
                            <div class ="col-md-6">
                                <?php echo form_input($show_expense_end_date+array('class'=>'form-control')); ?>
                            </div> 
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<h2>Search Result</h2>
<div class="row form-background">
    <div class="row">
        <div class="col-md-3">Expense Type</div>
        <div class="col-md-3">Amount</div>
        <div class="col-md-3">Description</div>
        <div class="col-md-3">Date</div>
    </div>
    <div class="row" id="div_expense_search_result">
        
    </div>
</div>