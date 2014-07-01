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
        <td ><?php echo '{%= sale_info.created_on%}'; ?></td>
        <td ><?php echo '{%= sale_info.product_name%}'; ?></td>
        <td ><?php echo '{%= sale_info.purchase_order_no%}'; ?></td>
        <td ><?php echo '{%= sale_info.total_sale%}'; ?></td>
        <td ><?php echo '{%= sale_info.category_unit %}'; ?></td>
        <td ><?php echo '{%= sale_info.purchase_unit_price%}'; ?></td>
        <td ><?php echo '{%= sale_info.sale_unit_price%}'; ?></td>
        <td ><?php echo '{%= sale_info.total_sale*sale_info.purchase_unit_price%}'; ?></td>
        <td ><?php echo '{%= sale_info.total_sale*sale_info.sale_unit_price%}'; ?></td>
        <td ><?php echo '<a href="'.base_url().'payment/show_customer_transactions/{%= sale_info.customer_id%}">Show</a>';?></td>
        <?php 
            if($this->session->userdata('user_type') != SALESMAN)
            {                                    
                echo '<td>';
                echo '{%= (sale_info.sale_unit_price-sale_info.purchase_unit_price)*sale_info.total_sale %}'; 
                echo '</td>';
            }        
        ?>
        <?php 
            if($this->session->userdata('user_type') != SALESMAN)
            {                                    
                echo '<td>';
                echo '<a href="'.base_url().'sale/return_sale_order/{%= sale_info.sale_order_no%}">Return</a>'; 
                echo '</td>';
            }        
        ?>
        <?php 
            if($this->session->userdata('user_type') != SALESMAN)
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
<h3><?php echo $this->lang->line("search_search_sales_search_sale"); ?></h3>
<div class ="form-horizontal form-background top-bottom-padding">
    <div class="table-responsive">
        <table class="table table-bordered">
            <tbody>
                <tr>
                    <td>
                        <label for="employee_list" class="col-md-6 control-label requiredField">
                            <?php echo $this->lang->line("search_search_sales_select_user"); ?>
                        </label>
                        <div class ="col-md-6">
                            <?php echo form_dropdown('employee_list', $employee_list+array('0' => 'All'), '0','class="form-control" id="employee_list"'); ?>
                        </div> 
                    </td> 
                    <td>
                        <label class="col-md-6 control-label requiredField">
                            <?php echo $this->lang->line("search_search_sales_total_sale_price"); ?> : 
                        </label>
                        <label id="label_total_sale_price" class="col-md-6 control-label requiredField">
                            <?php //echo $total_sale_price;?> 
                        </label>
                    </td>
                    <td>                        
                        <label for="start_date" class="col-md-6 control-label requiredField">
                            <?php echo $this->lang->line("search_search_sales_start_date"); ?>
                        </label>
                        <div class ="col-md-6">
                           <?php echo form_input($start_date+array('class'=>'form-control')); ?>
                        </div> 
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="product_list" class="col-md-6 control-label requiredField">
                            <?php echo $this->lang->line("search_search_sales_select_product"); ?>
                        </label>
                        <div class ="col-md-6">
                            <?php echo form_dropdown('product_list', $product_list+array('0' => 'All'), '0','class="form-control" id="product_list"'); ?>
                        </div>                        
                    </td>
                    <td>
                        <label class="col-md-6 control-label requiredField">
                            <?php echo $this->lang->line("search_search_sales_total_quantity"); ?> : 
                        </label>
                        <label id="label_total_quantity" class="col-md-6 control-label requiredField">
                            <?php //echo $total_expense;?>
                        </label>
                    </td>
                    <td>
                        <label for="end_date" class="col-md-6 control-label requiredField">
                            <?php echo $this->lang->line("search_search_sales_end_date"); ?>
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
                                if($this->session->userdata('user_type') != SALESMAN)
                                {                                    
                                    echo $this->lang->line("search_search_sales_total_profit").' : ';
                                }
                            ?>
                            
                        </label>
                        <label id="label_total_profit" class="col-md-6 control-label requiredField">
                            <?php 
                                if($this->session->userdata('user_type') != SALESMAN)
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
<h3><?php echo $this->lang->line("search_search_sales_search_result"); ?></h3>
<div class="form-background top-bottom-padding">
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th><?php echo $this->lang->line("search_search_sales_date_&_time"); ?></th>
                    <th><?php echo $this->lang->line("search_search_sales_product_name"); ?></th>
                    <th><?php echo $this->lang->line("search_search_sales_lot_no"); ?></th>
                    <th><?php echo $this->lang->line("search_search_sales_quantity"); ?></th>
                    <th><?php echo $this->lang->line("search_search_sales_product_unit"); ?></th>
                    <th><?php echo $this->lang->line("search_search_sales_purchase_unit_price"); ?></th>
                    <th><?php echo $this->lang->line("search_search_sales_sale_unit_price"); ?></th>
                    <th><?php echo $this->lang->line("search_search_sales_total_purchase_price"); ?></th>
                    <th><?php echo $this->lang->line("search_search_sales_total_sale_price"); ?></th>
                    <th><?php echo $this->lang->line("search_search_sales_transactions"); ?></th>
                    <?php 
                        if($this->session->userdata('user_type') != SALESMAN)
                        {                                    
                            echo '<th>'.$this->lang->line("search_search_sales_net_profit").'</th>';
                        }                            
                    ?> 
                    <?php 
                        if($this->session->userdata('user_type') != SALESMAN)
                        {                                    
                            echo '<th>'.$this->lang->line("search_search_sales_return").'</th>';
                        }                            
                    ?>
                    <?php 
                        if($this->session->userdata('user_type') != SALESMAN)
                        {                                    
                            echo '<th>'.$this->lang->line("search_search_sales_delete").'</th>';
                        }                            
                    ?>
                </tr>
            </thead>
            <tbody id="tbody_customer_sale_list">                
            
            </tbody>
        </table>
    </div>
</div>