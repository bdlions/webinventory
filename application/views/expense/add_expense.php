<script type="text/javascript">
    $(document).ready(function() {
        set_items();
    });
    $(function() {
        $("#expense_categories").on("change", function() {            
            set_items();
        });
    });
    function set_items()
    {
        $.ajax({
            type: "POST",
            url: '<?php echo base_url(); ?>' + "expense/getItems",
            data: {
                expense_type_id: $("#expense_categories").val(),
                access_type_id: '<?php echo ACCESS_TYPE_CREATE?>'
            },
            success: function(data) {
                var result = JSON.parse(data);
                if( $("#expense_categories").val() === '<?php echo EXPENSE_SHOP_TYPE_ID?>' )
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
                else if( $("#expense_categories").val() === '<?php echo EXPENSE_SUPPLIER_TYPE_ID?>' )
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
                else if( $("#expense_categories").val() === '<?php echo EXPENSE_STAFF_TYPE_ID?>' )
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
                else if( $("#expense_categories").val() === '<?php echo EXPENSE_EQUIPMENT_SUPPLIER_TYPE_ID?>' )
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

            }
        });
    }
</script>

<h3>Add Expense</h3>
<div class ="form-background form-horizontal top-bottom-padding">   
    <div class="row">
        <?php echo form_open("expense/add_expense", array('id' => 'form_add_expense', 'class' => 'form-horizontal')); ?>
        <div class ="col-md-5 col-md-offset-2">
            <div class ="row">
                <div class="col-md-4"></div>
                <div class="col-md-8"><?php echo $message; ?></div>
            </div>
            <div class="form-group">
                <label for="expense_categories" class="col-md-6 control-label requiredField">
                    Select Type
                </label>
                <div class ="col-md-6">
                    <?php echo form_dropdown('expense_categories', $expense_categories, $selected_expense_category, 'class="form-control" id="expense_categories"'); ?>
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
                <label for="first_name" class="col-md-6 control-label requiredField">
                    Expense Amount
                </label>
                <div class ="col-md-6">
                    <?php echo form_input($expense_amount+array('class'=>'form-control')); ?>
                </div> 
            </div>
            <div class="form-group">
                <label for="last_name" class="col-md-6 control-label requiredField">
                    Expense Description
                </label>
                <div class ="col-md-6">
                    <?php echo form_input($expense_description+array('class'=>'form-control')); ?>
                </div> 
            </div>
            <div class="form-group">
                <label for="submit_add_expense" class="col-md-6 control-label requiredField">

                </label>
                <div class ="col-md-3 col-md-offset-3">
                    <?php echo form_input($submit_add_expense+array('class'=>'form-control btn-success')); ?>
                </div> 
            </div>        
        </div>    
        <?php echo form_close(); ?>
    </div>    
</div>