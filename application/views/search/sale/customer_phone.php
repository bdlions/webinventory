<script type="text/javascript">
    $(function() {
        $("#button_search_sale").on("click", function() {
            $.ajax({
                dataType: 'json',
                type: "POST",
                url: '<?php echo base_url(); ?>' + "search/search_sales_by_customer_phone",
                data: {
                    phone: $("#phone").val()
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
        <td >{%= sale_info.customer_first_name%} {%= sale_info.customer_last_name%}</td>
        <td >{%= sale_info.customer_phone%}</td>
            <td >{%= sale_info.card_no%}</td>
        <td >{%= sale_info.product_name%}</td>
        <td ><?php echo '{%= sale_info.purchase_order_no%}'; ?></td>
        <td ><?php echo '{%= sale_info.total_sale%}'; ?></td>
        <td ><?php echo '{%= sale_info.unit_category%}'; ?></td>
        <td ><?php echo '{%= sale_info.purchase_unit_price%}'; ?></td>
        <td ><?php echo '{%= sale_info.sale_unit_price%}'; ?></td>
        <td ><?php echo '{%= sale_info.total_sale*sale_info.purchase_unit_price%}'; ?></td>
        <td ><?php echo '{%= sale_info.total_sale*sale_info.sale_unit_price%}'; ?></td>
        <td ><?php echo '<a href="'.base_url().'payment/show_customer_transactions/{%= sale_info.customer_id%}">Show</a>';?></td>
        <?php 
            if($this->session->userdata('user_type') != SALESMAN)
            {                                    
                echo '<td>';
                echo '{%= (sale_info.sale_unit_price-sale_info.purchase_unit_price)*sale_info.total_sale%}'; 
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
                echo '<a href="'.base_url().'sale/delete_sale/{%= sale_info.sale_order_no%}">Return</a>'; 
                echo '</td>';
            }        
        ?>
    </tr>
    {% sale_info = ((o instanceof Array) ? o[i++] : null); %}
    {% } %}
</script>
<h3>Search Customer sale by Card No</h3>
<div class ="form-horizontal form-background top-bottom-padding">
    <div class="table-responsive">
        <table class="table table-bordered">
            <tbody>
                <tr>
                    <td>
                        <label for="phone" class="col-md-6 control-label requiredField">
                            Phone
                        </label>
                        <div class ="col-md-6">
                            <?php echo form_input($phone+array('class'=>'form-control')); ?>
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
                        <label class="col-md-6 control-label requiredField">
                            Total Quantity : 
                        </label>
                        <label id="label_total_quantity" class="col-md-6 control-label requiredField">
                            <?php //echo $total_expense;?>
                        </label>
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
                                    echo 'Total Profit : ';
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
<h3>Search Result</h3>
<div class="form-background top-bottom-padding">
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Customer Name</th>
                    <th>Phone</th>
                    <th>Card No</th>
                    <th>Product Name</th>
                    <th>Lot No</th>
                    <th>Quantity</th>
                    <th>Product Unit</th>
                    <th>Purchase Unit Price</th>
                    <th>Sale Unit Price</th>
                    <th>Total Purchase Price</th>
                    <th>Total Sale Price</th>
                    <th>Transactions</th>
                    <?php 
                        if($this->session->userdata('user_type') != SALESMAN)
                        {                                    
                            echo '<th>Net Profit</th>';
                        }                            
                    ?> 
                    <?php 
                        if($this->session->userdata('user_type') != SALESMAN)
                        {                                    
                            echo '<th>Return</th>';
                        }                            
                    ?>
                    <?php 
                        if($this->session->userdata('user_type') != SALESMAN)
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