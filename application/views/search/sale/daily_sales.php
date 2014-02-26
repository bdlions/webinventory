<script type="text/javascript">
    $(function(){
        $( "#product_list" ).change(function() {
            $.ajax({
                dataType: 'json',
                type: "POST",
                url: '<?php echo base_url(); ?>' + "search/get_daily_sales",
                data: {
                    product_id: $("#product_list").val()
                },
                success: function(data) {
                    $("#tbody_daily_sale_list").html(tmpl("tmpl_daily_sale_list", data['sale_list'])); 
                    $("#label_total_product_sold").html(data['total_product_sold']+" pieces");
                    $("#label_total_profit").html(data['total_profit']);
                    $("#label_total_sale_price").html(data['total_sale_price']);
                    $("#label_total_expense").html(data['total_expense']);
                }
            });
        });
    });
</script>
<script type="text/x-tmpl" id="tmpl_daily_sale_list">
    {% var i=0, sale_info = ((o instanceof Array) ? o[i++] : o); %}
    {% while(sale_info){ %}
    <tr>
    <td ><?php echo '{%= sale_info.created_on%}'; ?></td>
    <td ><?php echo '{%= sale_info.purchase_order_no%}'; ?></td>
    <td ><?php echo '{%= sale_info.product_name%}'; ?></td>
    <td ><?php echo '{%= sale_info.quantity%}'; ?></td>
    <td ><?php echo '{%= sale_info.sale_unit_price%}'; ?></td>
    <td ><?php echo '{%= sale_info.total_sale_price%}'; ?></td>
    <td ><?php echo '{%= sale_info.total_sale_price-(sale_info.quantity*sale_info.purchase_unit_price)%}'; ?></td>
    <td >{%= sale_info.first_name%} {%=sale_info.last_name %}</td>
    </tr>
    {% sale_info = ((o instanceof Array) ? o[i++] : null); %}
    {% } %}
</script>
<h3>Daily Sale Page</h3>
<div class ="row form-horizontal form-background top-bottom-padding">
    <div class="table-responsive">
        <table class="table table-bordered">
            <tbody>
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
                            Total Product Sold : 
                        </label>
                        <label id="label_total_product_sold" class="col-md-6 control-label requiredField">
                            <?php echo $total_product_sold;?> pieces 
                        </label>
                    </td>
                    <td>
                        <label class="col-md-6 control-label requiredField">
                            Total Profit : 
                        </label>
                        <label id="label_total_profit" class="col-md-6 control-label requiredField">
                            <?php echo $total_profit;?>
                        </label>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label class="col-md-6 control-label requiredField">
                            Total Sale Price : 
                        </label>
                        <label id="label_total_sale_price" class="col-md-6 control-label requiredField">
                            <?php echo $total_sale_price;?> 
                        </label>
                    </td>
                    <td>
                        <label class="col-md-6 control-label requiredField">
                            Total Expense : 
                        </label>
                        <label id="label_total_expense" class="col-md-6 control-label requiredField">
                            <?php echo $total_expense;?>
                        </label>
                    </td>
                    <td>
                        <label class="col-md-6 control-label requiredField">
                            Total Due Collect : 
                        </label>
                        <label id="label_total_due_collect" class="col-md-6 control-label requiredField">
                            <?php echo $total_due_collect;?>
                        </label>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="form-group">
                            <label class="col-md-6 control-label requiredField">
                                Total Due : 
                            </label>
                            <label id="label_total_due" class="col-md-6 control-label requiredField">
                                <?php echo $total_due;?>
                            </label>
                        </div>
                    </td>
                    <td>
                        <label class="col-md-6 control-label requiredField">
                            Previous Balance : 
                        </label>
                        <label id="label_previous_balance" class="col-md-6 control-label requiredField">
                            0
                        </label>
                    </td>
                    <td>
                        <label class="col-md-6 control-label requiredField">
                            Total Net Balance : 
                        </label>
                        <label id="label_total_net_balance" class="col-md-6 control-label requiredField">
                            0
                        </label>
                    </td>
                </tr>
            </tbody>  
        </table>
    </div>     
</div>
<h3>Search Result</h3>
<div class="row form-background top-bottom-padding">
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Date & Time</th>
                    <th>Lot No</th>
                    <th>Product Name</th>
                    <th>Quantity</th>
                    <th>Sale Unit Price</th>
                    <th>Sub Total</th>
                    <th>Profit</th>
                    <th>Sale by Staff</th>
                    <th>Card No</th>
                </tr>
            </thead>
            <tbody id="tbody_daily_sale_list">                
                <?php foreach($sale_list as $sale_info) { ?>
                    <tr>
                        <td><?php echo $sale_info['created_on'];?></td>
                        <td><?php echo $sale_info['purchase_order_no'];?></td>
                        <td><?php echo $sale_info['product_name'];?></td>
                        <td><?php echo $sale_info['quantity'];?></td>
                        <td><?php echo $sale_info['sale_unit_price'];?></td>
                        <td><?php echo $sale_info['total_sale_price'];?></td>
                        <td><?php echo $sale_info['total_sale_price'] - ($sale_info['quantity']*$sale_info['purchase_unit_price']);?></td>
                        <td><?php echo $sale_info['first_name'].' '.$sale_info['last_name'];?></td>
                        <td><?php echo $sale_info['card_no'];?></td>                        
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>