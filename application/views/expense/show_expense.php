<script type="text/javascript">
    $(function() {
        $("#div_expense_description").html("");  
        $("#div_expense_amount").html("");  
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
                    expense_type_id: $("#expense_categories").val()
                },
                success: function(data) {
                    var result = JSON.parse(data);
                    var expense_list = result['expense_list'];
                    //var div_expense_amount = $("#div_selected_product_list").html();
                    var div_expense_description = "<h3>Description</h3>";
                    var div_expense_amount = "<h3>Amount</h3>";
                    for (var counter = 0; counter < expense_list.length; counter++)
                    {
                        var expense_info = expense_list[counter];
                        div_expense_description = div_expense_description + "<div class='wh_100'>"+expense_info['description']+"</div>";
                        div_expense_amount = div_expense_amount + "<div class='wh_100'>"+expense_info['expense_amount']+"</div>";
                    }
                    $("#div_expense_description").html(div_expense_description);  
                    $("#div_expense_amount").html(div_expense_amount);  
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
                                            <?php echo form_dropdown('expense_categories', $expense_categories+array('0' => 'All'), '','id="expense_categories"'); ?>
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
                                    <p class="clr">
                                    <div class="clr span10">
                                        <span class="fl">End Date</span>
                                        <span class="fr">
                                            <input id="show_expense_end_date"/>
                                        </span>			
                                    </div> 
                                    <p class="clr">
                                    <div class="clr span10">
                                        <span class="fl"></span>
                                        <span class="fr">
                                            <button id="button_search_expense" name="button_search_expense" class="btn btn-success fr">Search </button>
                                        </span>			
                                    </div>                                      
                                </fieldset>                                		
                            </div>                     
                        </div>
                    </div>
                </div>
            </div>
            <hr>
        </div>
    </div>				
    <p class="clr">&nbsp;</p>
    <div class="clr product_details sales_order_details specific span10">
        <div style="width:3%;" class="blank_div span0">
            <h3 class="" style="background-image:none;">&nbsp;</h3>
            
            <div class="wh_100"><p class="wh_100">&nbsp;</p></div>
            
        </div>
        <div id="div_expense_description" class="span1">
                       
        </div>
        <div id="div_expense_amount" class="span1">
                       
        </div>
                                              
    </div>
</div>
