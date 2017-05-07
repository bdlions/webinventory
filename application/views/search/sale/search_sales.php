<script type="text/javascript">
    $(function() {
        $('#start_date').datepicker({
            format: 'yyyy-mm-dd',
            startDate: '-3d'
        }).on('changeDate', function(ev) {
            $('#start_date').text($('#start_date').data('date'));
            $('#start_date').datepicker('hide');
        });
        $('#end_date').datepicker({
            format: 'yyyy-mm-dd',
            startDate: '-3d'
        }).on('changeDate', function(ev) {
            $('#end_date').text($('#end_date').data('date'));
            $('#end_date').datepicker('hide');
        });
        $("#button_search_sale").on("click", function() {
            $.ajax({
                dataType: 'json',
                type: "POST",
                url: '<?php echo base_url(); ?>' + "search/search_by_sales",
                data: {
                    user_id: $("#employee_list").val(),
                    product_id: $("#product_list").val(),
                    start_date: $("#start_date").val(),
                    end_date: $("#end_date").val()
                },
                success: function(data) {
                    $("#label_total_sale_price").html(data['total_sale_price']);
                    $("#label_total_quantity").html(data['total_quantity']);
                    $("#label_total_profit").html(data['total_profit']);
                    $("#tbody_customer_sale_list").html(tmpl("tmpl_customer_sale_list", data['sale_list']));                    
                }
            });
        });
    });
</script>
<script type="text/x-tmpl" id="tmpl_customer_sale_list">
    {% var i=0, sale_info = ((o instanceof Array) ? o[i++] : o); %}
    {% while(sale_info){ %}
    <tr>
        <td ><?php echo '{%= sale_info.salesman_first_name%}'; ?> <?php echo '{%= sale_info.salesman_last_name%}'; ?></td>
        <td ><?php echo '{%= sale_info.entry_first_name%}'; ?> <?php echo '{%= sale_info.entry_last_name%}'; ?></td>
        <td ><?php echo '{%= sale_info.created_on%}'; ?></td>
        <td ><?php echo '{%= sale_info.product_name%}'; ?></td>
        <td ><?php echo '{%= sale_info.purchase_order_no%}'; ?></td>
        <td ><?php echo '{%= sale_info.product_category1%}'; ?></td>
        <td ><?php echo '{%= sale_info.product_size%}'; ?></td>
        <td ><?php echo '{%= sale_info.total_sale%}'; ?></td>
        <td ><?php echo '{%= sale_info.category_unit %}'; ?></td>
        <?php 
            if($user_group['id'] == USER_GROUP_ADMIN || $user_group['id'] == USER_GROUP_MANAGER)
            {                                    
                echo '<td>';
                echo '{%= sale_info.purchase_unit_price%}';
                echo '</td>';
            }        
        ?>
        <td ><?php echo '{%= sale_info.sale_unit_price%}'; ?></td>
        <?php 
            if($user_group['id'] == USER_GROUP_ADMIN || $user_group['id'] == USER_GROUP_MANAGER)
            {                                    
                echo '<td>';
                echo '{%= sale_info.total_sale*sale_info.purchase_unit_price%}';
                echo '</td>';
            }        
        ?>   
        <td ><?php echo '{%= sale_info.total_sale*sale_info.sale_unit_price%}'; ?></td>
        <?php 
            if($user_group['id'] == USER_GROUP_ADMIN || $user_group['id'] == USER_GROUP_MANAGER)
            {                                    
                echo '<td>';
                echo '{%= (sale_info.sale_unit_price-sale_info.purchase_unit_price)*sale_info.total_sale %}'; 
                echo '</td>';
            }        
        ?>
        <?php 
            if($user_group['id'] == USER_GROUP_ADMIN || $user_group['id'] == USER_GROUP_MANAGER)
            {                                    
                echo '<td>';
                echo '<a href="'.base_url().'transaction/show_customer_transactions/{%= sale_info.customer_id%}">Show</a>';
                echo '</td>';
            }        
        ?>
        <?php 
            if($user_group['id'] == USER_GROUP_ADMIN || $user_group['id'] == USER_GROUP_MANAGER)
            {                                    
                echo '<td>';
                echo '<a href="'.base_url().'sale/return_sale_order/{%= sale_info.sale_order_no%}">Return</a>'; 
                echo '</td>';
            }        
        ?>
        <?php 
            if($user_group['id'] == USER_GROUP_ADMIN || $user_group['id'] == USER_GROUP_MANAGER)
            {                                    
                echo '<td>';
                echo '<a href="'.base_url().'sale/delete_sale/{%= sale_info.sale_order_no%}">Delete</a>'; 
                echo '</td>';
            }        
        ?>
    </tr>
    {% sale_info = ((o instanceof Array) ? o[i++] : null); %}
    {% } %}
</script>
<h3>Search Sale</h3>
<div class ="form-horizontal form-background top-bottom-padding">
    <div class="table-responsive">
        <table class="table table-bordered">
            <tbody>
                <tr>
                    <td>
                        <label for="employee_list" class="col-md-6 control-label requiredField">
                            Select User
                        </label>
                        <div class ="col-md-6">
                            <?php echo form_dropdown('employee_list', $employee_list+array('0' => 'All'), '0','class="form-control" id="employee_list"'); ?>
                        </div> 
                    </td> 
                    <td>
                        <label class="col-md-6 control-label requiredField">
                            Total Sale Price : 
                        </label>
                        <label id="label_total_sale_price" class="col-md-6 control-label requiredField">
                            <?php //echo $total_sale_price;?> 
                        </label>
                    </td>
                    <td>                        
                        <label for="start_date" class="col-md-6 control-label requiredField">
                            Start Date
                        </label>
                        <div class ="col-md-6">
                           <?php echo form_input($start_date+array('class'=>'form-control')); ?>
                        </div> 
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="product_list" class="col-md-6 control-label requiredField">
                            Select Product
                        </label>
                        <div class ="col-md-6">
                            <?php echo form_dropdown('product_list', $product_list+array('0' => 'All'), '0','class="form-control" id="product_list"'); ?>
                        </div>                        
                    </td>
                    <td>
                        <label class="col-md-6 control-label requiredField">
                            Total Quantity : 
                        </label>
                        <label id="label_total_quantity" class="col-md-6 control-label requiredField">
                            <?php //echo $total_expense;?>
                        </label>
                    </td>
                    <td>
                        <label for="end_date" class="col-md-6 control-label requiredField">
                            End Date
                        </label>
                        <div class ="col-md-6">
                            <?php echo form_input($end_date+array('class'=>'form-control')); ?>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="button_search_sale" class="col-md-6 control-label requiredField">

                        </label>
                        <div class ="col-md-6">
                            <?php echo form_input($button_search_sale+array('class'=>'form-control btn-success')); ?>
                        </div>                        
                    </td>
                    <td>
                        <label class="col-md-6 control-label requiredField">
                            <?php 
                                if($user_group['id'] == USER_GROUP_ADMIN || $user_group['id'] == USER_GROUP_MANAGER)
                                {                                    
                                    echo 'Total Profit : ';
                                }
                            ?>
                            
                        </label>
                        <label id="label_total_profit" class="col-md-6 control-label requiredField">
                            <?php 
                                if($user_group['id'] == USER_GROUP_ADMIN || $user_group['id'] == USER_GROUP_MANAGER)
                                {                                    
                                    //echo $total_profit;
                                }
                            ?>
                        </label>                      
                    </td>
                    <td>
                        
                    </td>
                </tr>
            </tbody>  
        </table>
    </div>     
</div>
<h3>Search Result</h3>
<div class="form-background top-bottom-padding">
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Staff</th>
                    <th>Entry</th>
                    <th>Time & Date</th>
                    <th>Product Name</th>
                    <th>Lot No</th>
                    <th>Sub Lot No</th>
                    <th>Size</th>
                    <th>Quantity</th>
                    <th>Product Unit</th>
                    <?php 
                        if($user_group['id'] == USER_GROUP_ADMIN || $user_group['id'] == USER_GROUP_MANAGER)
                        {                                    
                            echo '<th>Purchase Unit Price</th>';
                        }                            
                    ?> 
                    <th>Sale Unit Price</th>
                    <?php 
                        if($user_group['id'] == USER_GROUP_ADMIN || $user_group['id'] == USER_GROUP_MANAGER)
                        {                                    
                            echo '<th>Total Purchase Price</th>';
                        }                            
                    ?> 
                    <th>Total Sale Price</th>
                    <?php 
                        if($user_group['id'] == USER_GROUP_ADMIN || $user_group['id'] == USER_GROUP_MANAGER)
                        {                                    
                            echo '<th>Net Profit</th>';
                        }                            
                    ?> 
                    <?php 
                        if($user_group['id'] == USER_GROUP_ADMIN || $user_group['id'] == USER_GROUP_MANAGER)
                        {                                    
                            echo '<th>Transactions</th>';
                        }                            
                    ?> 
                    <?php 
                        if($user_group['id'] == USER_GROUP_ADMIN || $user_group['id'] == USER_GROUP_MANAGER)
                        {                                    
                            echo '<th>Return</th>';
                        }                            
                    ?>
                    <?php 
                        if($user_group['id'] == USER_GROUP_ADMIN || $user_group['id'] == USER_GROUP_MANAGER)
                        {                                    
                            echo '<th>Delete</th>';
                        }                            
                    ?>
                </tr>
            </thead>
            <tbody id="tbody_customer_sale_list">                
            
            </tbody>
        </table>
    </div>
</div>