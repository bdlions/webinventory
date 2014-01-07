<script type="text/javascript">
    $(function() {
        $("#show_expense_start_date").datepicker();
        $("#show_expense_end_date").datepicker();
        $("#expense_categories").on("change", function() {            
            $.ajax({
                type: "POST",
                url: '<?php echo base_url(); ?>' + "expense/getItems",
                data: {
                    expense_type_id: $("#expense_categories").val()
                },
                success: function(data) {
                    var result = JSON.parse(data);
                    if( $("#expense_categories").val() === '<?php echo $expense_type_list['shop']?>' )
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
                    else if( $("#expense_categories").val() === '<?php echo $expense_type_list['supplier']?>' )
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
                    else if( $("#expense_categories").val() === '<?php echo $expense_type_list['user']?>' )
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
        });
    });
</script>
<h2>Show Expense</h2>
<div class="clr search_details">
    <div class="clr span12">
        <div class="span12">
            <div class="row-fluid">
                <div class="tabbable">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#tabs1-pane1" data-toggle="tab">Expense Info</a></li>
                    </ul>
                    <div class="tab-content">
                        <?php echo form_open("expense/show_expense", array('id' => 'form_show_expense')); ?>
                        <div class="tab-pane active" id="tabs1-pane1">
                            <?php echo $message;?>
                            <p class="clr">										
                            <div class="span5">
                                <fieldset>
                                    <div class="clr span10">
                                        <span class="fl">&nbsp;</span>
                                        <span class="fr">
                                            &nbsp;
                                        </span>			
                                    </div>
                                    <div class="clr span10">
                                        <span class="fl">Select Type</span>
                                        <span class="fr">
                                            <?php echo form_dropdown('expense_categories', $expense_categories, '','id="expense_categories"'); ?>
                                        </span>			
                                    </div>
                                    <div class="clr span10">
                                        <span class="fl">Select Item</span>
                                        <span class="fr">
                                            <?php echo form_dropdown('item_list', $item_list, '','id="item_list"'); ?>
                                        </span>			
                                    </div>
                                    <div class="clr span10">
                                        <span class="fl">Start Date</span>
                                        <span class="fr">
                                            <input id="show_expense_start_date"/>
                                        </span>			
                                    </div>
                                    <div class="clr span10">
                                        <span class="fl">End Date</span>
                                        <span class="fr">
                                            <input id="show_expense_end_date"/>
                                        </span>			
                                    </div>  
                                    <div class="clr span10">
                                        <span class="fl"></span>
                                        <span class="fr">
                                            <?php echo form_submit($submit_show_expense); ?>
                                        </span>			
                                    </div>                                      
                                </fieldset>                                		
                            </div>                     
                        </div> 
                        <?php echo form_close(); ?>
                    </div>
                </div>
            </div>
            <hr>
        </div>
    </div>				
    <p class="clr">&nbsp;</p>
</div>
