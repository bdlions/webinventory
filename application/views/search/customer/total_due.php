<script type="text/javascript">
    $(function()
    {
        $("#button_search_customer_due").on("click", function() {
            waitScreen.show();
            $.ajax({
                dataType: 'json',
                type: "POST",
                url: '<?php echo base_url(); ?>' + "search/search_customer_by_total_due",
                data: {
                    search_category_name: $("#dropdown_search_customer").val(),
                    search_category_value: $("#input_search_value").val()
                },
                success: function(data) {
                    $("#label_total_due").html(data['total_due']);
                    $("#tbody_customer_list").html(tmpl("tmpl_customer_list", data['customer_list']));                                   
                    waitScreen.hide();
                }
            });
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
    <?php if ($shop_info['shop_type_id'] == SHOP_TYPE_SMALL){?>
    <td ><?php echo '{%= customer_info.card_no%}'; ?></td>
    <?php } ?>
    <td ><?php echo '{%= customer_info.due%}'; ?></td>
    <td ><?php echo '<a href="'.base_url().'transaction/show_customer_transactions/{%= customer_info.customer_id%}">Show</a>';?></td>
    </tr>
    {% customer_info = ((o instanceof Array) ? o[i++] : null); %}
    {% } %}
</script>
<h3>Search Customer by Total Due</h3>
<div class ="form-horizontal form-background top-bottom-padding">
    <div class="row" style="margin-top: 5px;">
        <div class="col-md-offset-1 col-md-5">
            <div class="row form-group">
                <div class ="col-md-6">
                    <label>Search Customer by Total Due:</label>
                </div>
                <div class ="col-md-6">
                    <?php echo form_dropdown('dropdown_search_customer', $customer_search_category, '0', 'id="dropdown_search_customer" class="form-control"'); ?>
                </div>
                <div class ="col-md-7"></div>
            </div>
            <div class="row form-group">
                <div class ="col-md-offset-6 col-md-6">
                    <input id="input_search_value" name="input_search_value" class="form-control">
                </div>
            </div>
            <div class="row form-group">
                <div class ="col-md-offset-8 col-md-4">
                    <input id="button_search_customer_due" class="form-control btn-success" type="reset" value="Search" name="button_search_customer_due">
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="row form-group">
                <div class ="col-md-offset-3 col-md-3">
                    <label>Total Due:</label>
                </div>
                <div class ="col-md-6">
                    <label id="label_total_due" name="label_total_due"></label>
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
                    <?php if($shop_info['shop_type_id'] == SHOP_TYPE_SMALL){ ?>
                    <th>Card No</th>
                    <?php } ?>
                    <th>Total Due</th>
                    <th>Transactions</th>
                </tr>
            </thead>
            <tbody id="tbody_customer_list">                
            
            </tbody>
        </table>
    </div>
</div>
<?php $this->load->view('common/wait_screen');