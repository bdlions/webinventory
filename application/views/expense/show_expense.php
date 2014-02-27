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
                dataType: 'json', 
                type: "POST",
                url: '<?php echo base_url(); ?>' + "expense/get_expense",
                data: {
                    expense_type_id: $("#expense_categories").val(),
                    start_date: $("#show_expense_start_date").val(),
                    end_date: $("#show_expense_end_date").val()
                },
                success: function(data) {
                    $("#tbody_expense_list").html(tmpl("tmpl_expense_list", data));
                }
            });
        });
    });
</script>
<script type="text/x-tmpl" id="tmpl_expense_list">
    {% var i=0, expense_info = ((o instanceof Array) ? o[i++] : o); %}
    {% while(expense_info){ %}
    <tr>
    <td>{%= expense_info.expense_amount %}</td>
    <td>{%= expense_info.description %}</td>
    <td>{%= expense_info.expense_date %}</td>
    </tr>
    {% expense_info = ((o instanceof Array) ? o[i++] : null); %}
    {% } %}
</script>
<h3>Search Expense</h3>
<div class ="row form-background top-bottom-padding">
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
<h3>Search Result</h3>
<div class="row form-background">
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Amount</th>
                    <th>Description</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody id="tbody_expense_list">                    

            </tbody>
        </table>
    </div>
</div>