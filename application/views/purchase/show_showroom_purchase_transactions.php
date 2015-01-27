<script type="text/javascript">
    $(function() {
        $("#button_search_transactions").on("click", function() {
            $.ajax({
                dataType: 'json',
                type: "POST",
                url: '<?php echo base_url(); ?>' + "purchase/get_showroom_purchase_transactions",
                data: {
                    purchase_order_no: $("#purchase_order_no").val()
                },
                success: function(data) {
                    $("#tbody_purchase_list").html(tmpl("tmpl_purchase_list", data['purchase_list']));                      
                }
            });
            return false;
        });
    });
</script>
<script type="text/x-tmpl" id="tmpl_purchase_list">
    {% var i=0, purchase_info = ((o instanceof Array) ? o[i++] : o); %}
    {% while(purchase_info){ %}
    <tr>
    <td ><?php echo '{%= purchase_info.created_on%}'; ?></td>
    <td ><?php echo '{%= purchase_info.first_name%}'.' '.'{%= purchase_info.last_name%}'; ?></td>
    <td ><?php echo '{%= purchase_info.purchase_order_no%}'; ?></td>
    <td ><?php echo '{%= purchase_info.product_name%}'; ?></td>
    <td ><?php echo '{%= purchase_info.unit_price%}'; ?></td>
    <td ><?php echo '{%= purchase_info.quantity%}'; ?></td>
    <td ><?php echo '{%= purchase_info.transaction_type%}'; ?></td>
    </tr>
    {% purchase_info = ((o instanceof Array) ? o[i++] : null); %}
    {% } %}
</script>
<h3>Search Purchase Transactions</h3>
<div class ="form-horizontal form-background top-bottom-padding">
    <div class="row">
        <div class ="col-md-6">
            <div class ="row">
                <div class ="col-md-12 form-horizontal">
                    <div class="row">
                        <div class ="col-md-6 margin-top-bottom">
                            <div class="form-group">
                                <label for="card_no" class="col-md-6 control-label requiredField">
                                    Lot No
                                </label>
                                <div class ="col-md-6">
                                    <?php echo form_input($purchase_order_no+array('class'=>'form-control')); ?>
                                </div> 
                            </div>
                            <div class="form-group">
                                <label for="button_search_customer" class="col-md-6 control-label requiredField">

                                </label>
                                <div class ="col-md-6">
                                    <?php echo form_input($button_search_transactions+array('class'=>'form-control btn-success')); ?>
                                </div> 
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>    
</div>
<h3>Search Result</h3>
<div class="form-background top-bottom-padding">
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Time</th>
                    <th>Supplier</th>
                    <th>Lot No</th>  
                    <th>Product Name</th> 
                    <th>Unit Price</th>
                    <th>Quantity</th> 
                    <th>Transaction Type</th> 
                </tr>
            </thead>
            <tbody id="tbody_purchase_list">                
            </tbody>
        </table>
    </div>
</div>