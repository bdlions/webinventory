<script type="text/javascript">
    $(function() {
        $("#button_search_customer").on("click", function() {
            $.ajax({
                dataType: 'json',
                type: "POST",
                url: '<?php echo base_url(); ?>' + "search/search_customers_by_total_purchased",
                data: {
                    total_purchased: $("#total_purchased").val()
                },
                success: function(data) {
                    $("#tbody_customer_list").html(tmpl("tmpl_customer_list", data['customer_list']));                      
                }
            });
            return false;
        });
    });
</script>
<script type="text/x-tmpl" id="tmpl_customer_list">
    {% var i=0, customer_info = ((o instanceof Array) ? o[i++] : o); %}
    {% while(customer_info){ %}
    <tr>
    <td ><?php echo '{%= customer_info.first_name%}'; ?></td>
    <td ><?php echo '{%= customer_info.last_name%}'; ?></td>
    <td ><?php echo '{%= customer_info.phone%}'; ?></td>
    <td ><?php echo '{%= customer_info.address%}'; ?></td>
    <?php if($shop_info['shop_type_id']==SHOP_TYPE_SMALL):?><td ><?php echo '{%= customer_info.card_no%}'; ?></td><?php endif;?>
    </tr>
    {% customer_info = ((o instanceof Array) ? o[i++] : null); %}
    {% } %}
</script>
<h3>Search Customer by Total Purchased</h3>
<div class ="form-horizontal form-background top-bottom-padding">
    <div class="row">
        <div class ="col-md-6">
            <div class ="row">
                <div class ="col-md-12 form-horizontal">
                    <div class="row">
                        <div class ="col-md-6 margin-top-bottom">
                            <?php echo form_open("search/download_search_customers_total_purchased", array('id' => 'form_download_search_customers_total_purchased', 'class' => 'form-horizontal')); ?>
                            <div class="form-group">
                                <label for="total_purchased" class="col-md-6 control-label requiredField">
                                    Total Purchased
                                </label>
                                <div class ="col-md-6">
                                    <?php echo form_input($total_purchased+array('class'=>'form-control')); ?>
                                </div> 
                            </div>
                            <div class="form-group">
                                <label for="button_search_customer" class="col-md-6 control-label requiredField">

                                </label>
                                <div class ="col-md-6">
                                    <?php echo form_input($button_search_customer+array('class'=>'form-control btn-success')); ?>
                                </div> 
                            </div>
                            <?php if($user_group['id'] != USER_GROUP_SALESMAN):?>
                            <div class="form-group">
                                <label for="button_download_customer" class="col-md-6 control-label requiredField">

                                </label>
                                <div class ="col-md-6">
                                    <?php echo form_input($button_download_customer+array('class'=>'form-control btn-success')); ?>
                                </div> 
                            </div>
                            <?php endif;?>
                            <?php echo form_close(); ?>
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
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Phone</th>
                    <th>Address</th>
                    <?php if($shop_info['shop_type_id']==SHOP_TYPE_SMALL):?><th>Card No</th><?php endif;?>
                </tr>
            </thead>
            <tbody id="tbody_customer_list">                
            
            </tbody>
        </table>
    </div>
</div>